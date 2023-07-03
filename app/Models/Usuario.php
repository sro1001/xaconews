<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

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
 * @property Rol $rol
 *
 * @package App\Models
 */
class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword, Notifiable;


	protected $table = 'users';

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

	/**
	 * Devuelve el roles asociado al usuario
	 *
	 * @access public
	 * @return Rol
	 */
	public function rol()
	{
		return $this->belongsTo(Rol::class, 'rol_id');
	}
}
