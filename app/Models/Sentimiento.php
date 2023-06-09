<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sentimiento
 *
 * @property int $id
 * @property string $nombre
 * @property string $positivo
 *
 * @property Collection|Noticia[] $noticias
 *
 * @package App\Models
 */
class Sentimiento extends Model
{
	protected $table = 'sentimientos';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'positivo'
	];

	//Constantes para los sentimientos
	const ALEGRIA = 1;
    const TRISTEZA = 2;
	const CONFIANZA = 3;
	const MIEDO = 4;
	const ORGULLO = 5;
    const ENFADO = 6;
	const SATISFACCION = 7;
	const ASCO = 8;
	const AMOR = 9;
    const CULPA = 10;
	const POSITIVO_NEGATIVO = 11;

	/**
	 * Devuelve las noticias y puntuación asociadas al sentimiento
	 *
	 * @access public
	 * @return Collection|Noticia
	 */
	public function noticias()
	{
		return $this->belongsToMany(Noticia::class, 'noticias_sentimientos')
					->withPivot('id', 'puntuacion');
	}
}
