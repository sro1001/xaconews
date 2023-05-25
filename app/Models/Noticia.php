<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Noticia
 *
 * @property int $id
 * @property string $titulo
 * @property string $url
 * @property int $bien_interes_cultural_id
 * @property int $fuente_id
 * @property Carbon $fecha
 * @property string|null $texto
 * @property string $google_news_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BienInteresCultural $bienes_interes_cultural
 * @property Fuente $fuente
 *
 * @package App\Models
 */
class Noticia extends Model
{
	protected $table = 'noticias';

	protected $casts = [
		'bien_interes_cultural_id' => 'int',
		'fuente_id' => 'int'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'titulo',
		'url',
		'bien_interes_cultural_id',
		'fuente_id',
		'fecha',
		'texto',
		'google_news_id'
	];

	public function bien_interes_cultural()
	{
		return $this->belongsTo(BienInteresCultural::class, 'bien_interes_cultural_id');
	}

	public function fuente()
	{
		return $this->belongsTo(Fuente::class);
	}

	public function formatearTexto()
	{
		$lineas_noticia = preg_split('/\r\n|\r|\n/', $this->texto);
		return array_filter($lineas_noticia);
	}
}
