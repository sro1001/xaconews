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
}
