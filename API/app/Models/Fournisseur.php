<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fournisseur
 * 
 * @property int $id
 * @property string $nom
 * @property int $addresse
 * 
 * @property Collection|Produit[] $produits
 *
 * @package App\Models
 */
class Fournisseur extends Model
{
	protected $table = 'fournisseur';
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

	public function produits()
	{
		return $this->hasMany(Produit::class, 'fournisseur');
	}
}
