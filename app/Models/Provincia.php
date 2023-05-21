<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Provincia
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Collection|BienInteresCultural[] $bienes_interes_cultural
 * @property Collection|Municipio[] $municipios
 *
 * @package App\Models
 */
class Provincia extends Model
{
	protected $table = 'provincias';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function bienes_interes_cultural()
	{
		return $this->hasMany(BienInteresCultural::class);
	}

	public function municipios()
	{
		return $this->hasMany(Municipio::class);
	}

	public static function obtenerProvinciasBuscador(){
		$provincias = Provincia::orderBy('nombre')->get();
		$array_provincias_buscador = array();
		foreach($provincias as $provincia){
			$array_provincias_buscador[$provincia->id] = $provincia->nombre;
		}
		return $array_provincias_buscador;
	}
}
