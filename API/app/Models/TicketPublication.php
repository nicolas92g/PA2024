<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketPublication
 * 
 * @property int $id
 * @property string|null $titre
 * @property string $contenu
 * @property string|null $etat
 * @property Carbon $horaire
 * @property int $utilisateur
 * @property int|null $parent
 * 
 * @property TicketPublication|null $ticket_publication
 * @property Collection|TicketPublication[] $ticket_publications
 *
 * @package App\Models
 */
class TicketPublication extends Model
{
	protected $table = 'ticket_publication';
	public $timestamps = false;

	protected $casts = [
		'horaire' => 'datetime',
		'utilisateur' => 'int',
		'parent' => 'int'
	];

	protected $fillable = [
		'titre',
		'contenu',
		'etat',
		'horaire',
		'utilisateur',
		'parent'
	];

	public function ticket_publication()
	{
		return $this->belongsTo(TicketPublication::class, 'parent');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur');
	}

	public function ticket_publications()
	{
		return $this->hasMany(TicketPublication::class, 'parent');
	}
}
