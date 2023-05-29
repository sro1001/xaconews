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

	const ADMIN = 1;
    const EDITOR = 2;
	const LECTOR = 3;

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'rol_id');
	}

	public static function obtenerRolesBuscador(){
		$roles = Rol::orderBy('nombre')->get();
		$array_roles_buscador = array();
		foreach($roles as $rol){
			$array_roles_buscador[$rol->id] = $rol->nombre;
		}
		return $array_roles_buscador;
	}

	public static function obtenerTextoRol($rol_id){
		$rol = Rol::find($rol_id);
		return $rol->nombre;
	}
}
