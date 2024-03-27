<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Beneficie
 * 
 * @property int $beneficiaire
 * @property int $session
 * 
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class Beneficie extends Model
{
	protected $table = 'beneficie';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'beneficiaire' => 'int',
		'session' => 'int'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'beneficiaire');
	}

	public function session()
	{
		return $this->belongsTo(Session::class, 'session');
	}
}
