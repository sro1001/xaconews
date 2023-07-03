<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Municipio
 *
 * @property int $id
 * @property string $nombre
 * @property int $provincia_id
 *
 * @property Provincia $provincia
 * @property Collection|BienInteresCultural[] $bienes_interes_cultural
 * @property Collection|Localidad[] $localidades
 *
 * @package App\Models
 */
class Municipio extends Model
{
	protected $table = 'municipios';
	public $timestamps = false;

	protected $casts = [
		'provincia_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'provincia_id'
	];

	/**
	 * Devuelve la provincia del municipio
	 *
	 * @access public
	 * @return Provincia
	 */
	public function provincia()
	{
		return $this->belongsTo(Provincia::class);
	}

	/**
	 * Devuelve los bienes de interés cultural asociadas al municipio
	 *
	 * @access public
	 * @return Collection|BienInteresCultural
	 */
	public function bienes_interes_cultural()
	{
		return $this->hasMany(BienInteresCultural::class);
	}

	/**
	 * Devuelve las localidades asociadas al municipio
	 *
	 * @access public
	 * @return Collection|Localidad
	 */
	public function localidades()
	{
		return $this->hasMany(Localidad::class);
	}

	/**
	 * Devuelve los municipios en un formato útil para campos select
	 *
	 * @access public
	 * @static
	 * @return Array
	 */
	public static function obtenerMunicipiosBuscador(){
		$municipios = Municipio::orderBy('nombre')->get();
		$array_municipios_buscador = array();
		foreach($municipios as $municipio){
			$array_municipios_buscador[$municipio->id] = $municipio->nombre;
		}
		return $array_municipios_buscador;
	}
}
