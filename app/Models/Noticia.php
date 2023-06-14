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
 * @property int $estado_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BienesInteresCultural $bienes_interes_cultural
 * @property Fuente $fuente
 * @property NoticiaEstado $estado
 * @property Collection|Sentimiento[] $sentimientos
 *
 * @package App\Models
 */
class Noticia extends Model
{
	protected $table = 'noticias';

	protected $casts = [
		'bien_interes_cultural_id' => 'int',
		'fuente_id' => 'int',
		'estado_id' => 'int'
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
		'google_news_id',
		'estado_id'
	];

	const MAX_CHARS_TEXTO_EXCEL = 32000;
	const MAX_CHARS_TEXTO_CHAT_GPT = 8000;

	public function bien_interes_cultural()
	{
		return $this->belongsTo(BienInteresCultural::class, 'bien_interes_cultural_id');
	}

	public function fuente()
	{
		return $this->belongsTo(Fuente::class);
	}

	public function estado()
	{
		return $this->belongsTo(NoticiaEstado::class);
	}

	public function sentimientos()
	{
		return $this->belongsToMany(Sentimiento::class, 'noticias_sentimientos')
					->withPivot('id', 'puntuacion');
	}

	public function formatearTexto()
	{
		$lineas_noticia = preg_split('/\r\n|\r|\n/', $this->texto);
		return array_filter($lineas_noticia);
	}
}
