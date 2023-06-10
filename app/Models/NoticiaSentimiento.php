<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class NoticiaSentimiento
 *
 * @property int $id
 * @property int $noticia_id
 * @property int $sentimiento_id
 * @property float $puntuacion
 *
 * @property Noticia $noticia
 * @property Sentimiento $sentimiento
 *
 * @package App\Models
 */
class NoticiaSentimiento extends Model
{
	protected $table = 'noticias_sentimientos';
	public $timestamps = false;

	protected $casts = [
		'noticia_id' => 'int',
		'sentimiento_id' => 'int',
		'puntuacion' => 'float'
	];

	protected $fillable = [
		'noticia_id',
		'sentimiento_id',
		'puntuacion'
	];

	public function noticia()
	{
		return $this->belongsTo(Noticia::class);
	}

	public function sentimiento()
	{
		return $this->belongsTo(Sentimiento::class);
	}

	public static function obtenerPuntuacionSentimientos(){
		$count_registros = NoticiaSentimiento::select(DB::raw('SUM(noticias_sentimientos.puntuacion) as suma_total'))->get()[0]->suma_total;
		$sentimientos_positivos = NoticiaSentimiento::join('sentimientos','sentimientos.id','noticias_sentimientos.sentimiento_id')
											->where('sentimientos.positivo','=',1)
											->select(DB::raw('SUM(noticias_sentimientos.puntuacion) as suma_puntuacion'))
											->first();
		$porcentaje_positivos = round(($sentimientos_positivos->suma_puntuacion / $count_registros) * 100,2);
		return [$porcentaje_positivos,round(100 - $porcentaje_positivos,2)];
	}

	public static function obtenerSentimientosPorPuntuacion(){
		$sentimientos = NoticiaSentimiento::join('sentimientos','sentimientos.id','noticias_sentimientos.sentimiento_id')
											->select('sentimientos.nombre',DB::raw('COUNT(noticias_sentimientos.puntuacion) as casos'),DB::raw('(SUM(noticias_sentimientos.puntuacion)/COUNT(noticias_sentimientos.puntuacion))*10 as suma_puntuacion'))
											->groupBy('sentimientos.nombre')
											->orderBy('suma_puntuacion','desc');
		return $sentimientos;
	}
}
