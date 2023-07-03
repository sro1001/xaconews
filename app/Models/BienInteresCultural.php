<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BienInteresCultural
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripción
 * @property int $municipio_id
 * @property int $localidad_id
 * @property int $provincia_id
 *
 * @property Localidad $localidad
 * @property Municipio $municipio
 * @property Provincia $provincia
 * @property Collection|Noticia[] $noticias
 *
 * @package App\Models
 */
class BienInteresCultural extends Model
{
	protected $table = 'bienes_interes_cultural';
	public $timestamps = false;

	protected $casts = [
		'municipio_id' => 'int',
		'localidad_id' => 'int',
		'provincia_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'descripción',
		'municipio_id',
		'localidad_id',
		'provincia_id'
	];

	/**
	 * Devuelve la localidad del bien cultural
	 *
	 * @access public
	 * @return Localidad
	 */
	public function localidad()
	{
		return $this->belongsTo(Localidad::class, 'localidad_id');
	}

	/**
	 * Devuelve el municipio del bien cultural
	 *
	 * @access public
	 * @return Municipio
	 */
	public function municipio()
	{
		return $this->belongsTo(Municipio::class);
	}

	/**
	 * Devuelve la provincia del bien cultural
	 *
	 * @access public
	 * @return Provincia
	 */
	public function provincia()
	{
		return $this->belongsTo(Provincia::class);
	}

	/**
	 * Devuelve las noticias asociadas al bien cultural
	 *
	 * @access public
	 * @return Collection|Noticia
	 */
	public function noticias()
	{
		return $this->hasMany(Noticia::class, 'bien_interes_cultural_id');
	}

	/**
	 * Construye la cadena de parámetros con la que se llama a Google News
	 *
	 * @access public
	 * @return String
	 */
	public function obtenerCadenaFormatoGn(){
		$nombre_bien_cultural = $this->nombre;
		$nombre_bien_cultural_limpio = str_replace(" - ", " ",$nombre_bien_cultural);
		$nombre_bien_cultural_separado = explode(" ",$nombre_bien_cultural_limpio);
		$municipio_separado = explode(" ",$this->municipio->nombre);
		$cadenaGn = array_merge($nombre_bien_cultural_separado, $municipio_separado);
		$cadenaFormatoGn = implode("+",$cadenaGn);
		// 29/05 Anidamos el texto de camino de santiago para tener resultados más precisos
		if(str_contains($cadenaFormatoGn, 'Camino')){
			$cadenaFormatoGn = $cadenaFormatoGn.'+De+Santiago';
		}else{
			$cadenaFormatoGn = $cadenaFormatoGn.'Camino+De+Santiago';
		}
		return $cadenaFormatoGn;
	}

	/**
	 * Devuelve los Ids de bienes culturales según municipio
	 *
	 * @access public
	 * @param Int $municipio_id
	 * @static
	 * @return Array
	 */
	public static function obtenerIdsBienesPorMunicipio($municipio_id){
		$bienes = BienInteresCultural::where('municipio_id','=',$municipio_id);
		return $bienes->pluck('id')->toArray();
	}

	/**
	 * Devuelve los Ids de bienes culturales según provincia
	 *
	 * @access public
	 * @param Int $provincia_id
	 * @static
	 * @return Array
	 */
	public static function obtenerIdsBienesPorProvincia($provincia_id){
		$bienes = BienInteresCultural::where('provincia_id','=',$provincia_id);
		return $bienes->pluck('id')->toArray();
	}


	/**
	 * Devuelve los bienes de interés cultural en un formato útil para campos select
	 *
	 * @access public
	 * @static
	 * @return Array
	 */
	public static function obtenerBienesBuscador(){
		$bienes_culturales = BienInteresCultural::orderBy('nombre')->get();
		$array_bienes_buscador = array();
		foreach($bienes_culturales as $bien_cultural){
			$array_bienes_buscador[$bien_cultural->id] = $bien_cultural->nombre.' - '.$bien_cultural->municipio->nombre;
		}
		return $array_bienes_buscador;
	}
}
