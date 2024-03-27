<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activite
 * 
 * @property int $id
 * @property string $nom
 * @property string $description
 * @property int $type
 * 
 * @property TypeActivite $type_activite
 * @property Collection|Session[] $sessions
 *
 * @package App\Models
 */
class Activite extends Model
{
	protected $table = 'activite';
	public $timestamps = false;

	protected $casts = [
		'type' => 'int'
	];

	protected $fillable = [
		'nom',
		'description',
		'type'
	];

	public function type_activite()
	{
		return $this->belongsTo(TypeActivite::class, 'type');
	}

	public function sessions()
	{
		return $this->hasMany(Session::class, 'activite');
	}
}
