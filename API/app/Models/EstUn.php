<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstUn
 * 
 * @property int $utilisateur
 * @property int $role
 * 
 *
 * @package App\Models
 */
class EstUn extends Model
{
	protected $table = 'est_un';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'utilisateur' => 'int',
		'role' => 'int'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'role');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur');
	}
}
