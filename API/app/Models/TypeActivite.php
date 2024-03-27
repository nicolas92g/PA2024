<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeActivite
 * 
 * @property int $id
 * @property string $nom
 * @property string $description
 * 
 * @property Collection|Activite[] $activites
 *
 * @package App\Models
 */
class TypeActivite extends Model
{
	protected $table = 'type_activite';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'description'
	];

	public function activites()
	{
		return $this->hasMany(Activite::class, 'type');
	}
}
