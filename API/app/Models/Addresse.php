<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Addresse
 * 
 * @property int $id
 * @property string $premiere_ligne
 * @property int $code_postal
 * @property string $ville
 * 
 * @property Collection|Annexe[] $annexes
 * @property Collection|Entrepot[] $entrepots
 * @property Collection|Fournisseur[] $fournisseurs
 * @property Collection|Utilisateur[] $utilisateurs
 *
 * @package App\Models
 */
class Addresse extends Model
{
	protected $table = 'addresse';
	public $timestamps = false;

	protected $casts = [
		'code_postal' => 'int'
	];

	protected $fillable = [
		'premiere_ligne',
		'code_postal',
		'ville'
	];

	public function annexes()
	{
		return $this->hasMany(Annexe::class, 'addresse');
	}

	public function entrepots()
	{
		return $this->hasMany(Entrepot::class, 'addresse');
	}

	public function fournisseurs()
	{
		return $this->hasMany(Fournisseur::class, 'addresse');
	}

	public function utilisateurs()
	{
		return $this->hasMany(Utilisateur::class, 'addresse');
	}
}
