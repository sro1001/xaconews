<?php

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

class AnalisisNoticiasController extends Controller
{

    public function index(Request $request) {
        if ($request->ajax()) {

        } else {

        }
    }

    public function analisis_sentimientos($noticia_id,Request $request) {
        $noticia = Noticia::find($noticia_id);
        $llamada_chatGpt = curl_init();
        $texto_noticia_llamada = preg_replace('/\r\n|\r|\n/','', $noticia->texto);
        curl_setopt($llamada_chatGpt, CURLOPT_URL, 'https://api.openai.com/v1/completions');
        curl_setopt($llamada_chatGpt, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada_chatGpt, CURLOPT_POST, true);
        $post_data = array(
            "model" => "text-davinci-003",
            "prompt" => config('noticias.CHATGPT')['QUESTION'].' '.$texto_noticia_llamada,
            "temperature" => 0.5,
            "max_tokens" => 500,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
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
        curl_close($llamada_chatGpt);
        $texto_respuesta = json_decode($respuesta)->choices[0]->text;
        $lineas_respuesta = explode(';',str_replace(array('[', ']'),'',preg_replace('/\r\n|\r|\n/','', $texto_respuesta)));
        foreach($lineas_respuesta as $linea_respuesta){
            if(!empty($linea_respuesta)){
                $nombre_sentimiento = explode(':',$linea_respuesta)[0];
                $sentimiento_id = Sentimiento::comprobarSentimiento($nombre_sentimiento,str_contains($linea_respuesta, 'Positivo'));
                $noticia_sentimiento = new NoticiaSentimiento();
                $noticia_sentimiento->noticia_id = $noticia_id;
                $noticia_sentimiento->sentimiento_id = $sentimiento_id;
                $noticia_sentimiento->puntuacion = trim($this->get_string_between($linea_respuesta,':',','));
                $noticia_sentimiento->save();
            }
        }
        $noticia->estado_id = NoticiaEstado::VISIBLE_ANALIZADA;
        $noticia->save();
        $analisis_noticias_control = SincronizacionNoticias::all()[0];
        $analisis_noticias_control->limite_llamadas_chatGPT -= 1;
        $analisis_noticias_control->save();
        return redirect()->route('noticias.index');
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}
