<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Utilisateur
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $mail
 * @property string $mot_de_passe_hash
 * @property string $sel
 * @property bool $mail_verifie
 * @property Carbon $derniere_connexion
 * @property int $addresse
 *
 * @property Collection|AUneCompetence[] $a_une_competences
 * @property Collection|Beneficie[] $beneficies
 * @property Collection|Demande[] $demandes
 * @property Collection|EstUn[] $est_uns
 * @property Collection|Intervient[] $intervients
 *
 * @package App\Models
 */
class Utilisateur extends Authenticatable
{
    use Notifiable, HasApiTokens;

	protected $table = 'utilisateur';
	public $timestamps = false;

	protected $casts = [
		'mail_verifie' => 'bool',
		'derniere_connexion' => 'datetime',
		'addresse' => 'int'
	];

	protected $fillable = [
		'prenom',
		'nom',
		'mail',
		'mot_de_passe_hash',
		'sel',
		'mail_verifie',
		'derniere_connexion',
		'addresse'
	];

	public function addresse()
	{
		return $this->belongsTo(Addresse::class, 'addresse');
	}

    public function roles()
    {
        return Role::whereIn('id', function ($query) {
            $query->select('role')->from(with(new EstUn())->getTable())->where('utilisateur', $this->id);
        });
    }

    public static function exists($id): bool {
        return Utilisateur::query()->where("id", $id)->exists();
    }

    public static function getFromId($id) : ?Utilisateur{
        if (self::exists($id))
            return Utilisateur::query()->where("id", $id)->get()[0];
        return NULL;
    }

    public function isAdmin() : bool
    {
        return EstUn::query()->where('utilisateur', $this->id)->where('role', 1)->exists();
    }

    public function isBenevole() : bool
    {
        return EstUn::query()->where('utilisateur', $this->id)->where('role', 2)->exists();
    }
}
