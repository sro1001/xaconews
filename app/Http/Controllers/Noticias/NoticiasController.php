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
use Carbon\Carbon;
use \Datetime;

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
                            "X-RapidAPI-Key: ".config('noticias.RAPID_API')['KEY'],
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
}
