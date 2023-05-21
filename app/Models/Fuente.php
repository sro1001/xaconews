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

	public function noticias()
	{
		return $this->hasMany(Noticia::class);
	}

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

	public function limpiarFuenteEnTitulo($titulo){
		$cadena_eliminar = " - ".$this->nombre;
		return str_replace($cadena_eliminar,"",$titulo);
	}

	public function esFuenteHttps(){
		return str_contains($this->url,"https");
	}

	public static function obtenerFuentesBuscador(){
		$fuentes = Fuente::orderBy('nombre')->get();
		$array_fuentes_buscador = array();
		foreach($fuentes as $fuente){
			$array_fuentes_buscador[$fuente->id] = $fuente->nombre;
		}
		return $array_fuentes_buscador;
	}
}
