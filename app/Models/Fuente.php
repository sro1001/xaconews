<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fuente
 * 
 * @property int $id
 * @property string $nombre
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Noticia[] $noticias
 *
 * @package App\Models
 */
class Fuente extends Model
{
	protected $table = 'fuentes';

	protected $fillable = [
		'nombre',
		'url'
	];

	public function noticias()
	{
		return $this->hasMany(Noticia::class);
	}
}
