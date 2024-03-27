<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * 
 * @property int $id
 * @property string $nom
 * @property string $emplacement
 * @property Carbon $horaire
 * @property string $description
 * @property int $activite
 * 
 * @property Collection|Beneficie[] $beneficies
 * @property Collection|Intervient[] $intervients
 *
 * @package App\Models
 */
class Session extends Model
{
	protected $table = 'session';
	public $timestamps = false;

	protected $casts = [
		'horaire' => 'datetime',
		'activite' => 'int'
	];

	protected $fillable = [
		'nom',
		'emplacement',
		'horaire',
		'description',
		'activite'
	];

	public function activite()
	{
		return $this->belongsTo(Activite::class, 'activite');
	}

	public function beneficies()
	{
		return $this->hasMany(Beneficie::class, 'session');
	}

	public function intervients()
	{
		return $this->hasMany(Intervient::class, 'session');
	}
}
