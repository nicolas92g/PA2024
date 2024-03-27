<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Demande
 * 
 * @property int $id
 * @property string $description
 * @property int $utilisateur
 * @property int $nature
 * 
 * @property NatureDemande $nature_demande
 *
 * @package App\Models
 */
class Demande extends Model
{
	protected $table = 'demande';
	public $timestamps = false;

	protected $casts = [
		'utilisateur' => 'int',
		'nature' => 'int'
	];

	protected $fillable = [
		'description',
		'utilisateur',
		'nature'
	];

	public function nature_demande()
	{
		return $this->belongsTo(NatureDemande::class, 'nature');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur');
	}
}
