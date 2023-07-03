<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fuente
 *
 * @property int $id
 * @property string $nombre
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Noticia[] $noticias
 *
 * @package App\Models
 */
class Fuente extends Model
{
	protected $table = 'fuentes';

	protected $fillable = [
		'nombre',
		'url'
	];

	/**
	 * Devuelve las noticias asociadas a la fuente
	 *
	 * @access public
	 * @return Collection|Noticia
	 */
	public function noticias()
	{
		return $this->hasMany(Noticia::class);
	}

	/**
	 * A partir de la fuente de la noticia, comprueba si existe en la aplicación
	 * o es una fuente nueva que tiene que ser creada
	 *
	 * @access public
	 * @param String $data_fuente
	 * @static
	 * @return Fuente
	 */
	public static function analizarFuente($data_fuente){
		$nombre_fuente = ((array)$data_fuente)[0];
		$existe_fuente = Fuente::where('nombre',$nombre_fuente)->get();
		if(count($existe_fuente) == 0){
			$nueva_fuente = New Fuente();
			$nueva_fuente->nombre = $nombre_fuente;
			$nueva_fuente->url = ((array)$data_fuente->attributes()->url)[0];
			$nueva_fuente->save();
			return $nueva_fuente;
		}else{
			return $existe_fuente[0];
		}
	}

	/**
	 * Elimina el texto de la fuente del título de la noticia recibido
	 * por Google News
	 *
	 * @access public
	 * @param String $titulo
	 * @return String
	 */
	public function limpiarFuenteEnTitulo($titulo){
		$cadena_eliminar = " - ".$this->nombre;
		return str_replace($cadena_eliminar,"",$titulo);
	}

	/**
	 * Devuelve true si la fuente tiene una Url https y false en caso contrario
	 *
	 * @access public
	 * @return Boolean
	 */
	public function esFuenteHttps(){
		return str_contains($this->url,"https");
	}

	/**
	 * Devuelve las fuentes en un formato útil para campos select
	 *
	 * @access public
	 * @static
	 * @return Array
	 */
	public static function obtenerFuentesBuscador(){
		$fuentes = Fuente::orderBy('nombre')->get();
		$array_fuentes_buscador = array();
		foreach($fuentes as $fuente){
			$array_fuentes_buscador[$fuente->id] = $fuente->nombre;
		}
		return $array_fuentes_buscador;
	}
}
