<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Rol extends Model
{
	protected $table = 'roles';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	//Constantes para los roles
	const ADMIN = 1;
    const EDITOR = 2;
	const LECTOR = 3;

	/**
	 * Devuelve los usuarios asociados a cada rol
	 *
	 * @access public
	 * @return Collection|Usuario
	 */
	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'rol_id');
	}

	/**
	 * Devuelve los roles en un formato útil para campos select
	 *
	 * @access public
	 * @static
	 * @return Array
	 */
	public static function obtenerRolesBuscador(){
		$roles = Rol::orderBy('nombre')->get();
		$array_roles_buscador = array();
		foreach($roles as $rol){
			$array_roles_buscador[$rol->id] = $rol->nombre;
		}
		return $array_roles_buscador;
	}

	/**
	 * Devuelve el nombre del rol pasado por parámetro
	 *
	 * @access public
	 * @param Int $rol_id
	 * @static
	 * @return String
	 */
	public static function obtenerTextoRol($rol_id){
		$rol = Rol::find($rol_id);
		return $rol->nombre;
	}
}
