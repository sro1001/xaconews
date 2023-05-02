<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property string $nombre_completo
 * @property string $email
 * @property int $rol_id
 * @property string $username
 * @property string $password
 * @property string|null $telefono
 * @property bool $activo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role $role
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';

	protected $casts = [
		'rol_id' => 'int',
		'activo' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nombre_completo',
		'email',
		'rol_id',
		'username',
		'password',
		'telefono',
		'activo'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'rol_id');
	}
}
