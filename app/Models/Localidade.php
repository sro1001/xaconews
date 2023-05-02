<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Localidade
 * 
 * @property int $id
 * @property string $nombre
 * @property int $municipio_id
 * 
 * @property Municipio $municipio
 * @property Collection|BienesInteresCultural[] $bienes_interes_culturals
 *
 * @package App\Models
 */
class Localidade extends Model
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

	public function bienes_interes_culturals()
	{
		return $this->hasMany(BienesInteresCultural::class, 'localidad_id');
	}
}
