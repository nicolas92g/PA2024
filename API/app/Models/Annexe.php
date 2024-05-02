<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Annexe
 * 
 * @property int $id
 * @property string $nom
 * @property int $addresse
 * 
 * @property Collection|Camion[] $camions
 *
 * @package App\Models
 */
class Annexe extends Model
{
	protected $table = 'annexe';
	public $timestamps = false;

	protected $casts = [
		'addresse' => 'int'
	];

	protected $fillable = [
		'nom',
		'addresse'
	];

	public function addresse()
	{
		return $this->belongsTo(Addresse::class, 'addresse');
	}

	public function camions()
	{
		return $this->hasMany(Camion::class, 'annexe');
	}
}
