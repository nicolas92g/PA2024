<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Etape
 * 
 * @property int $addresse
 * @property int $maraude
 * 
 * @property Session $session
 *
 * @package App\Models
 */
class Etape extends Model
{
	protected $table = 'etape';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'addresse' => 'int',
		'maraude' => 'int'
	];

	public function addresse()
	{
		return $this->belongsTo(Addresse::class, 'addresse');
	}

	public function session()
	{
		return $this->belongsTo(Session::class, 'maraude');
	}
}
