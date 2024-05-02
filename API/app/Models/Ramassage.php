<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ramassage
 * 
 * @property int $id
 * @property Carbon $horaire_debut
 * @property int $camion
 * @property int $utilisateur
 * 
 * @property Collection|Ramasse[] $ramasses
 *
 * @package App\Models
 */
class Ramassage extends Model
{
	protected $table = 'ramassage';
	public $timestamps = false;

	protected $casts = [
		'horaire_debut' => 'datetime',
		'camion' => 'int',
		'utilisateur' => 'int'
	];

	protected $fillable = [
		'horaire_debut',
		'camion',
		'utilisateur'
	];

	public function camion()
	{
		return $this->belongsTo(Camion::class, 'camion');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur');
	}

	public function ramasses()
	{
		return $this->hasMany(Ramasse::class, 'ramassage');
	}
}
