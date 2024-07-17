<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Produit
 *
 * @property int $id
 * @property string $quantite
 * @property Carbon $date_limite
 * @property string $nom
 * @property string $description
 * @property int $fournisseur
 * @property int $entrepot
 *
 * @property Collection|Ramasse[] $ramasses
 *
 * @package App\Models
 */
class Produit extends Model
{
	protected $table = 'produit';
	public $timestamps = false;

	protected $casts = [
		'date_limite' => 'datetime',
		'fournisseur' => 'int',
		'entrepot' => 'int',
		'maraude' => 'int'
	];

	protected $fillable = [
		'quantite',
		'date_limite',
		'nom',
		'description',
		'fournisseur',
		'entrepot'
	];

	public function entrepot()
	{
		return $this->belongsTo(Entrepot::class, 'entrepot');
	}

	public function fournisseur()
	{
		return $this->belongsTo(Fournisseur::class, 'fournisseur');
	}

    public function maraude()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur');
    }

	public function ramasses()
	{
		return $this->hasMany(Ramasse::class, 'produit');
	}
}
