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

	//Constantes para cada estado de noticia
	const SIN_REVISAR = 1;
    const VISIBLE = 2;
	const OCULTO = 3;
	const VISIBLE_ANALIZADA = 4;

	/**
	 * Devuelve las noticias asociadas a cada estado
	 *
	 * @access public
	 * @return Collection|Noticia
	 */
	public function noticias()
	{
		return $this->hasMany(Noticia::class, 'estado_id');
	}

	/**
	 * Obtiene los estados para los campos de select
	 *
	 * @access public
	 * @param Boolean $edicion
	 * @static
	 * @return Array
	 */
	public static function obtenerEstadosNoticiasBuscador($edicion = false){
		if($edicion){
			$estados = NoticiaEstado::where('id','!=',NoticiaEstado::VISIBLE_ANALIZADA)->orderBy('nombre')->get();
		}else{
			$estados = NoticiaEstado::orderBy('nombre')->get();
		}

		$array_estados_buscador = array();
		foreach($estados as $estado){
			$array_estados_buscador[$estado->id] = $estado->nombre;
		}
		return $array_estados_buscador;
	}
}
