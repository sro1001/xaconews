<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
