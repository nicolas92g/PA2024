<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Camion
 * 
 * @property int $id
 * @property string $modele
 * @property float $limite_poids
 * @property int $annexe
 * 
 * @property Collection|Ramassage[] $ramassages
 *
 * @package App\Models
 */
class Camion extends Model
{
	protected $table = 'camion';
	public $timestamps = false;

	protected $casts = [
		'limite_poids' => 'float',
		'annexe' => 'int'
	];

	protected $fillable = [
		'modele',
		'limite_poids',
		'annexe'
	];

	public function annexe()
	{
		return $this->belongsTo(Annexe::class, 'annexe');
	}

	public function ramassages()
	{
		return $this->hasMany(Ramassage::class, 'camion');
	}
}
