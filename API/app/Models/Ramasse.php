<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ramasse
 * 
 * @property int $produit
 * @property int $ramassage
 * @property int $ordre
 * 
 *
 * @package App\Models
 */
class Ramasse extends Model
{
	protected $table = 'ramasse';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'produit' => 'int',
		'ramassage' => 'int',
		'ordre' => 'int'
	];

	protected $fillable = [
		'ordre'
	];

	public function produit()
	{
		return $this->belongsTo(Produit::class, 'produit');
	}

	public function ramassage()
	{
		return $this->belongsTo(Ramassage::class, 'ramassage');
	}
}
