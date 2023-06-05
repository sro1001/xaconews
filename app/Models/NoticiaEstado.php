<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NoticiaEstado
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Collection|Noticia[] $noticias
 *
 * @package App\Models
 */
class NoticiaEstado extends Model
{
	protected $table = 'noticias_estados';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	const SIN_REVISAR = 1;
    const VISIBLE = 2;
	const OCULTO = 3;
	const VISIBLE_ANALIZADA = 4;

	public function noticias()
	{
		return $this->hasMany(Noticia::class, 'estado_id');
	}

	public static function obtenerEstadosNoticiasBuscador(){
		$estados = NoticiaEstado::all();
		$array_estados_buscador = array();
		foreach($estados as $estado){
			$array_estados_buscador[$estado->id] = $estado->nombre;
		}
		return $array_estados_buscador;
	}
}
