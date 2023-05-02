<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Localidad
 *
 * @property int $id
 * @property string $nombre
 * @property int $municipio_id
 *
 * @property Municipio $municipio
 * @property Collection|BienInteresCultural[] $bienes_interes_cultural
 *
 * @package App\Models
 */
class Localidad extends Model
{
	protected $table = 'localidades';
	public $timestamps = false;

	protected $casts = [
		'municipio_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'municipio_id'
	];

	public function municipio()
	{
		return $this->belongsTo(Municipio::class);
	}

	public function bienes_interes_cultural()
	{
		return $this->hasMany(BienInteresCultural::class, 'localidad_id');
	}
}
