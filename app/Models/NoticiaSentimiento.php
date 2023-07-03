<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sentimiento;
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

	/**
	 * Devuelve la noticia asociada a la relación entre Noticia y Sentimiento
	 *
	 * @access public
	 * @return Noticia
	 */
	public function noticia()
	{
		return $this->belongsTo(Noticia::class);
	}

	/**
	 * Devuelve el sentimiento asociado a la relación entre Noticia y Sentimiento
	 *
	 * @access public
	 * @return Sentimiento
	 */
	public function sentimiento()
	{
		return $this->belongsTo(Sentimiento::class);
	}

	/**
	 * Obtiene los datos para el gráfico de positividad
	 *
	 * @access public
	 * @static
	 * @return Array
	 */
	public static function obtenerPuntuacionSentimientos(){
		$count_registros = NoticiaSentimiento::select(DB::raw('SUM(noticias_sentimientos.puntuacion) as suma_total'))->get()[0]->suma_total;
		$positivoNegativo_por_puntuacion = NoticiaSentimiento::where('sentimiento_id','=',Sentimiento::POSITIVO_NEGATIVO)
											->select(DB::raw("COUNT(*) as num_resultados,case
																WHEN puntuacion < 4 THEN 'grupo_1'
																WHEN puntuacion > 3 AND puntuacion < 7 THEN 'grupo_2'
																WHEN puntuacion > 6 AND puntuacion < 9 THEN 'grupo_3'
																WHEN puntuacion > 8 THEN 'grupo_4'
															  END AS grupo_grafica"))
											->groupBy('grupo_grafica')
											->get();
		return [$positivoNegativo_por_puntuacion[0]->num_resultados,$positivoNegativo_por_puntuacion[1]->num_resultados,
				$positivoNegativo_por_puntuacion[2]->num_resultados,$positivoNegativo_por_puntuacion[3]->num_resultados];
	}

	/**
	 * Obtiene los datos para el gráfico de puntuación por sentimiento
	 *
	 * @access public
	 * @static
	 * @return Collection|NoticiaSentimiento
	 */
	public static function obtenerSentimientosPorPuntuacion(){
		$sentimientos = NoticiaSentimiento::join('sentimientos','sentimientos.id','noticias_sentimientos.sentimiento_id')
											->select('sentimientos.nombre',DB::raw('COUNT(noticias_sentimientos.puntuacion) as casos'),DB::raw('ROUND((SUM(noticias_sentimientos.puntuacion)/COUNT(noticias_sentimientos.puntuacion))*10,1) as suma_puntuacion'))
											->where('sentimiento_id','!=',Sentimiento::POSITIVO_NEGATIVO)
											->groupBy('sentimientos.nombre')
											->orderBy('suma_puntuacion','desc');
		return $sentimientos;
	}
}
