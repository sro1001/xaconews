<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

	public function localidad()
	{
		return $this->belongsTo(Localidad::class, 'localidad_id');
	}

	public function municipio()
	{
		return $this->belongsTo(Municipio::class);
	}

	public function provincia()
	{
		return $this->belongsTo(Provincia::class);
	}
}