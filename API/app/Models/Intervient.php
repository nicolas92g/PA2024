<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Intervient
 * 
 * @property int $intervenant
 * @property int $session
 * 
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class Intervient extends Model
{
	protected $table = 'intervient';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'intervenant' => 'int',
		'session' => 'int'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'intervenant');
	}

	public function session()
	{
		return $this->belongsTo(Session::class, 'session');
	}
}
