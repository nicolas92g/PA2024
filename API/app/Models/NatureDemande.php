<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NatureDemande
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Demande[] $demandes
 *
 * @package App\Models
 */
class NatureDemande extends Model
{
	protected $table = 'nature_demande';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function demandes()
	{
		return $this->hasMany(Demande::class, 'nature');
	}
}
