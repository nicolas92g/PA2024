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
 * @property TypeActivite $type
 *
 * @package App\Models
 */
class Demande extends Model
{
	protected $table = 'demande';
	public $timestamps = false;

	protected $casts = [
		'utilisateur' => 'int',
		'type' => 'int'
	];

	protected $fillable = [
		'description',
		'utilisateur',
		'type'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur');
	}
}
