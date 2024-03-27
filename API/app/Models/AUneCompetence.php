<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AUneCompetence
 * 
 * @property int $utilisateur
 * @property int $competence
 * 
 *
 * @package App\Models
 */
class AUneCompetence extends Model
{
	protected $table = 'a_une_competence';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'utilisateur' => 'int',
		'competence' => 'int'
	];

	public function competence()
	{
		return $this->belongsTo(Competence::class, 'competence');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur');
	}
}
