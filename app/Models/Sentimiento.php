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

	public function noticias()
	{
		return $this->belongsToMany(Noticia::class, 'noticias_sentimientos')
					->withPivot('id', 'puntuacion');
	}

	public static function comprobarSentimiento($nombre_sentimiento,$positivo){
		$check_sentimiento = Sentimiento::where('nombre','=',$nombre_sentimiento)->get();
		if(count($check_sentimiento) == 0){
			$nuevo_sentimiento = new Sentimiento();
			$nuevo_sentimiento->nombre = $nombre_sentimiento;
			$nuevo_sentimiento->positivo = $positivo;
			$nuevo_sentimiento->save();
			return $nuevo_sentimiento->id;
		}else{
			return $check_sentimiento[0]->id;
		}
	}
}