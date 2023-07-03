<?php

/**
 * Created by Sergio Ruiz Orodea.
 */

namespace App\Http\Controllers\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BienInteresCultural;
use App\Models\SincronizacionNoticias;
use App\Models\Usuario;
use App\Models\Noticia;
use App\Models\NoticiaEstado;
use App\Models\NoticiaSentimiento;
use App\Models\Sentimiento;
use Carbon\Carbon;
use \Datetime;
use Yajra\DataTables\DataTables;

/**
 * Class AnalisisNoticiasController
 *
 * @package App\Http\Controllers\Noticias
 */
class AnalisisNoticiasController extends Controller
{

    /**
	 * Devuelve la vista con el dashboard de estadísticias
	 *
	 * @access public
	 * @param Request $request
	 * @return View
	 */
    public function index(Request $request) {
        $positiveChartLabels = ['0-3','4-6','7-8','9-10'];
        $positiveChartData = NoticiaSentimiento::obtenerPuntuacionSentimientos();
        $datosSentimientosChart = NoticiaSentimiento::obtenerSentimientosPorPuntuacion();
        $sentimientosChartLabels = $datosSentimientosChart->pluck('nombre')->toArray();
        $datosSentimientosChartDataPuntuacion = $datosSentimientosChart->pluck('suma_puntuacion')->toArray();
        $datosSentimientosChartDataCasos = $datosSentimientosChart->pluck('casos')->toArray();
        return view('sentimientos.index', [
            'positiveChartLabels' => json_encode(array_values($positiveChartLabels)),
            'positiveChartData' => json_encode(array_values($positiveChartData)),
            'sentimientosChartLabels' => json_encode(array_values($sentimientosChartLabels)),
            'sentimientosChartDataCasos' => json_encode(array_values($datosSentimientosChartDataCasos)),
            'sentimientosChartDataPuntuacion' => json_encode(array_values($datosSentimientosChartDataPuntuacion))
        ]);
    }

    /**
	 * Ejecuta el análisis de sentimientos para la noticia
	 *
	 * @access public
     * @param Int $noticia_id
	 * @param Request $request
	 * @return Route
	 */
    public function analisisSentimientos($noticia_id,Request $request) {
        $noticia = Noticia::find($noticia_id);
        $llamada_chatGpt = curl_init();
        $texto_noticia_llamada = preg_replace('/\r\n|\r|\n/','', $noticia->texto);
        curl_setopt($llamada_chatGpt, CURLOPT_URL, 'https://api.openai.com/v1/completions');
        curl_setopt($llamada_chatGpt, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada_chatGpt, CURLOPT_POST, true);
        $post_data = array(
            "model" => config('noticias.CHATGPT')['MODEL'],
            "prompt" => config('noticias.CHATGPT')['QUESTION'].' '.$texto_noticia_llamada,
            "temperature" =>  config('noticias.CHATGPT')['TEMPERATURE'],
            "max_tokens" =>  config('noticias.CHATGPT')['MAX_TOKENS'],
            "top_p" =>  config('noticias.CHATGPT')['TOP_P'],
            "frequency_penalty" =>  config('noticias.CHATGPT')['FREQUENCY_PENALTY'],
            "presence_penalty" =>  config('noticias.CHATGPT')['PRESENCE_PENALTY']
        );
        $post_data = json_encode($post_data);
        curl_setopt($llamada_chatGpt, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($llamada_chatGpt, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($llamada_chatGpt, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($llamada_chatGpt, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('CHAT_GPT_KEY') ?? '',
        ]);
        $respuesta = curl_exec($llamada_chatGpt);
        $post_data_positividad = array(
            "model" => config('noticias.CHATGPT')['MODEL'],
            "prompt" => config('noticias.CHATGPT')['QUESTION_POSITIVIDAD'].' '.$texto_noticia_llamada,
            "temperature" =>  config('noticias.CHATGPT')['TEMPERATURE'],
            "max_tokens" =>  config('noticias.CHATGPT')['MAX_TOKENS'],
            "top_p" =>  config('noticias.CHATGPT')['TOP_P'],
            "frequency_penalty" =>  config('noticias.CHATGPT')['FREQUENCY_PENALTY'],
            "presence_penalty" =>  config('noticias.CHATGPT')['PRESENCE_PENALTY']
        );
        $post_data_positividad = json_encode($post_data_positividad);
        curl_setopt($llamada_chatGpt, CURLOPT_POSTFIELDS, $post_data_positividad);
        $respuesta_positividad = curl_exec($llamada_chatGpt);
        curl_close($llamada_chatGpt);
        $texto_respuesta = json_decode($respuesta)->choices[0]->text;
        $lineas_respuesta = str_replace('"','',preg_replace('/\r\n|\r|\n/','', $texto_respuesta));
        $sentimientos = Sentimiento::all();
        foreach($sentimientos as $sentimiento){
            $posicion = strpos($lineas_respuesta,$sentimiento->nombre);
            $puntuacion = substr($lineas_respuesta, $posicion + strlen($sentimiento->nombre)+ 2 , 1);
            if(is_numeric($puntuacion)){
                $noticia_sentimiento = new NoticiaSentimiento();
                $noticia_sentimiento->noticia_id = $noticia_id;
                $noticia_sentimiento->sentimiento_id = $sentimiento->id;
                $noticia_sentimiento->puntuacion = $puntuacion;
                $noticia_sentimiento->save();
            }
        }
        $texto_respuesta_positividad = json_decode($respuesta_positividad)->choices[0]->text;
        $contenido_respuesta = str_replace('"','',preg_replace('/\r\n|\r|\n/','', $texto_respuesta_positividad));
        if(is_numeric(trim($contenido_respuesta))){
            $noticia_sentimiento = new NoticiaSentimiento();
            $noticia_sentimiento->noticia_id = $noticia_id;
            $noticia_sentimiento->sentimiento_id = Sentimiento::POSITIVO_NEGATIVO;
            $noticia_sentimiento->puntuacion = trim($contenido_respuesta);
            $noticia_sentimiento->save();
        }
        $noticia->estado_id = NoticiaEstado::VISIBLE_ANALIZADA;
        $noticia->save();
        $analisis_noticias_control = SincronizacionNoticias::all()[0];
        $analisis_noticias_control->limite_llamadas_chatGPT -= 1;
        $analisis_noticias_control->save();
        return redirect()->route('noticias.ver',$noticia_id);
    }

}
