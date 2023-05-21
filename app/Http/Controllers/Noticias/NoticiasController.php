<?php

namespace App\Http\Controllers\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BienInteresCultural;
use App\Models\SincronizacionNoticias;
use App\Models\Usuario;
use App\Models\Noticia;
use App\Models\Fuente;
use App\Models\Rol;
use App\Models\Municipio;
use App\Models\Provincia;
use Carbon\Carbon;
use \Datetime;
use Yajra\DataTables\DataTables;

class NoticiasController extends Controller
{

    public function sincronizar_noticias(){
        ini_set('memory_limit','2G');
		set_time_limit(360*60);
        $bienes_interes_cultural = BienInteresCultural::all();
        $count_noticias = 0;
        foreach($bienes_interes_cultural as $bien_interes_cultural){
            $busqueda = $bien_interes_cultural->obtenerCadenaFormatoGn();
            $data_xml = simplexml_load_file(
                config('noticias.GOOGLE_NEWS')['PREFIJO_LLAMADA'].
                $busqueda.
                config('noticias.GOOGLE_NEWS')['SUFIJO_LLAMADA']
            );
            //$urls_buenas = $data_xml->channel->item->getNamespaces();
            foreach($data_xml->channel->item as $noticia){
                $fecha_noticia = date_create_from_format(DateTime::RSS, $noticia->pubDate);
                if($fecha_noticia->format('Y-m-d') > Carbon::yesterday()->format('Y-m-d')){
                    $count_noticias += 1;
                    $sincro_noticias_control = SincronizacionNoticias::all()[0];
                    $limite_llamadas_api = $sincro_noticias_control->limite_llamadas_api_noticias;
                    $google_news_id = ((array)$noticia->guid)[0];
                    $existe_noticia = Noticia::where('google_news_id',$google_news_id)->count();
                    if($existe_noticia == 0 && $limite_llamadas_api > 25){
                        $nueva_noticia = new Noticia();
                        $nueva_noticia->google_news_id = $google_news_id;
                        $nueva_noticia->bien_interes_cultural_id = $bien_interes_cultural->id;
                        $fuente = Fuente::analizarFuente($noticia->source);
                        $nueva_noticia->fuente_id = $fuente->id;
                        $nueva_noticia->titulo = str_replace('"','',$fuente->limpiarFuenteEnTitulo($noticia->title));
                        $nueva_noticia->fecha = date_create_from_format(DateTime::RSS, $noticia->pubDate);
                        $llamada_gn_link = curl_init();
                        curl_setopt($llamada_gn_link, CURLOPT_URL, $noticia->link);
                        curl_setopt($llamada_gn_link, CURLOPT_HEADER, TRUE);
                        curl_setopt($llamada_gn_link, CURLOPT_FOLLOWLOCATION, TRUE);
                        curl_setopt($llamada_gn_link, CURLOPT_RETURNTRANSFER, TRUE);
                        $contenido = curl_exec($llamada_gn_link);
                        curl_close($llamada_gn_link);
                        $url_encontrada = false;
                        if($fuente->esFuenteHttps()){
                            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $contenido, $links_encontrados);
                        }else{
                            preg_match_all('#\bhttp?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $contenido, $links_encontrados);
                        }
                        foreach($links_encontrados[0] as $link_encontrado){
                            if(str_contains($link_encontrado,$fuente->url)){
                                $url_encontrada = true;
                                $nueva_noticia->url = trim($link_encontrado);
                                break;
                            }
                        }
                        $llamada_texto_noticia = curl_init();
                        curl_setopt($llamada_texto_noticia, CURLOPT_URL, config('noticias.RAPID_API')['URL']);
                        curl_setopt($llamada_texto_noticia, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($llamada_texto_noticia, CURLOPT_ENCODING, "");
                        curl_setopt($llamada_texto_noticia, CURLOPT_MAXREDIRS, config('noticias.RAPID_API')['MAX_REDIRECTS']);
                        curl_setopt($llamada_texto_noticia, CURLOPT_TIMEOUT, config('noticias.RAPID_API')['TIMEOUT']);
                        curl_setopt($llamada_texto_noticia, CURLOPT_HTTP_VERSION, config('noticias.RAPID_API')['HTTP_VERSION']);
                        $cadena_post_data = 'url='.$nueva_noticia->url.
                                            '&xss='.config('noticias.RAPID_API')['XSS_PARAMETER'].
                                            '&lang='.config('noticias.RAPID_API')['LANG_PARAMETER'].
                                            '&links='.config('noticias.RAPID_API')['LINKS_PARAMETER'].
                                            '&content='.config('noticias.RAPID_API')['CONTENT_PARAMETER'];
                        curl_setopt($llamada_texto_noticia, CURLOPT_POSTFIELDS, $cadena_post_data);
                        $array_header = [
                            "X-RapidAPI-Host: ".config('noticias.RAPID_API')['HOST'],
                            "X-RapidAPI-Key: ".env('RAPID_API_KEY'),
                            "content-type: ".config('noticias.RAPID_API')['CONTENT_TYPE']
                        ];
                        curl_setopt($llamada_texto_noticia, CURLOPT_HTTPHEADER, $array_header);
                        $respuesta_noticia = curl_exec($llamada_texto_noticia);
                        $texto_noticia = json_decode($respuesta_noticia,true);
                        curl_close($llamada_texto_noticia);
                        $nueva_noticia->texto = $texto_noticia['content'];
                        if(!empty($texto_noticia['title'])){
                            $nueva_noticia->titulo = $texto_noticia['title'];
                        }
                        $nueva_noticia->save();
                        $sincro_noticias_control->limite_llamadas_api_noticias = $sincro_noticias_control->limite_llamadas_api_noticias - 1;
                        $sincro_noticias_control->save();
                    }
                }
            }
        }
    }

    public function index(Request $request) {
        if ($request->ajax()) {

            $noticias = Noticia::query();
            if (filled($request->get('titulo'))) {
                $noticias = $noticias->where('titulo', 'LIKE', '%'.$request->get('titulo').'%');
            }
            if(filled($request->get('fuente_id'))){
                $noticias = $noticias->where('fuente_id', '=', $request->get('fuente_id'));
            }
            if(filled($request->get('bien_cultural_id'))){
                $noticias = $noticias->where('bien_interes_cultural_id', '=', $request->get('bien_cultural_id'));
            }
            if(filled($request->get('municipio_id'))){
                $bienes_ids = BienInteresCultural::obtenerIdsBienesPorMunicipio($request->get('municipio_id'));
                $noticias = $noticias->whereIn('bien_interes_cultural_id',$bienes_ids);
            }
            if(filled($request->get('provincia_id'))){
                $bienes_ids = BienInteresCultural::obtenerIdsBienesPorProvincia($request->get('provincia_id'));
                $noticias = $noticias->whereIn('bien_interes_cultural_id',$bienes_ids);
            }

            return Datatables::of($noticias->get())
                ->addColumn('bien_cultural', function ($item) use (&$request) {
                    return $item->bien_interes_cultural->nombre;
                })
                ->addColumn('municipio', function ($item) use (&$request) {
                    return $item->bien_interes_cultural->municipio->nombre;
                })
                ->addColumn('provincia', function ($item) use (&$request) {
                    return $item->bien_interes_cultural->provincia->nombre;
                })
                ->addColumn('fuente', function ($item) use (&$request) {
                    return $item->fuente->nombre;
                })
                ->addColumn('action', function ($item) use (&$request) {
                    return '<a href="'.route('noticias.ver', $item->id).'" class="btn btn-xs btn-primary"><ion-icon name="eye"></ion-icon></a>&nbsp;
                        <a href="'.$item->url.'" class="btn btn-xs btn-primary" target="_blanck"><ion-icon name="arrow-redo-circle"></ion-icon></a>&nbsp;
                        <a class="btn btn-xs btn-primary" onclick="script_noticias.modal_eliminar(event)" data-id="'.$item->id.'" title="Eliminar noticia" data-url="'.route('noticias.eliminar').'"><ion-icon name="trash"></ion-icon></a>';
                })
                ->rawColumns(['action'])
                ->setRowId('orden')
                ->make(true);

        } else {
            $fuentes = Fuente::obtenerFuentesBuscador();
            $municipios = Municipio::obtenerMunicipiosBuscador();
            $provincias = Provincia::obtenerProvinciasBuscador();
            $bienes = BienInteresCultural::obtenerBienesBuscador();
            return view('noticias.index', [
                'fuentes_buscador' => $fuentes,
                'municipios_buscador' => $municipios,
                'provincias_buscador' => $provincias,
                'bienes_buscador' => $bienes
            ]);
        }
    }

    public function ver($id) {
        $noticia = Noticia::findOrFail($id);

        return view('noticias.ver', [
            'noticia' => $noticia
        ]);
    }

}
