<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SincronizacionNoticias
 *
 * @property int $id
 * @property int $limite_llamadas_api_noticias
 * @property int limite_llamadas_chatGPT
 *
 * @package App\Models
 */
class SincronizacionNoticias extends Model
{
	protected $table = 'sincronizacion_noticias';
	public $timestamps = false;

	protected $fillable = [
		'limite_llamadas_api_noticias',
        'limite_llamadas_chatGPT'
	];
	
}
