<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Competence
 * 
 * @property int $id
 * @property string $nom
 * @property string $description
 * 
 * @property Collection|AUneCompetence[] $a_une_competences
 *
 * @package App\Models
 */
class Competence extends Model
{
	protected $table = 'competence';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'description'
	];

	public function a_une_competences()
	{
		return $this->hasMany(AUneCompetence::class, 'competence');
	}
}
