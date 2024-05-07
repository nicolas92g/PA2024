<?php

namespace App\Http\Controllers;

use App\Models\EstUn;
use App\Models\TicketPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    function listTickets(){
        $role = EstUn::query()->where('utilisateur', '=', self::getUser()->id)->get();
        if (count($role) == 0) {
            return self::jsonError('you are not able to do that');
        }
        $role = $role[0]->role;

        $wantedColumns = ['id', 'titre', 'contenu', 'horaire', 'etat', 'utilisateur'];

        if ($role == 1) {
            return TicketPublication::query()->whereNull('parent')->get($wantedColumns);
        }

        return TicketPublication::query()->whereNull('parent')->where('utilisateur', '=', self::getUser()->id)->get($wantedColumns);
    }

    function createTicket(Request $r){
        return $this->createFunctionTemplate($r, TicketPublication::class,
            ['title' => 'titre', 'content' => 'contenu', 'state' => 'etat', 'timestamp' => 'horaire'],
            false,
            ['utilisateur' => self::getUser()->id]
        );
    }

    function updateState(Request $r){
        if (!isset($r->ticket) || !isset($r->state)){
            return self::jsonError('missing parameters');
        }

        TicketPublication::query()->where('id', $r->ticket)->update(['etat' => $r->state]);
        return self::jsonOk();
    }

    function listResponses(Request $r){
        if (!isset($r->ticket)){
            return self::jsonError('ticket id is not provided.');
        }

        $wantedColumns = ['id', 'contenu', 'horaire', 'utilisateur'];

        return TicketPublication::query()->where('parent', '=', $r->ticket)->get($wantedColumns);
    }

    function createResponse(Request $r){
        return $this->createFunctionTemplate($r, TicketPublication::class,
            ['content' => 'contenu', 'timestamp' => 'horaire', 'parent' => 'parent'],
            false,
            ['utilisateur' => self::getUser()->id]
        );
    }
}
