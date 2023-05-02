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
 * @property Collection|BienesInteresCultural[] $bienes_interes_culturals
 * @property Collection|Localidade[] $localidades
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

	public function provincia()
	{
		return $this->belongsTo(Provincia::class);
	}

	public function bienes_interes_culturals()
	{
		return $this->hasMany(BienesInteresCultural::class);
	}

	public function localidades()
	{
		return $this->hasMany(Localidade::class);
	}
}
