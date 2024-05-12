<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\NatureDemande;
use App\Models\TypeActivite;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    function list()
    {
        return Demande::All();
    }

    function create(Request $r){
        if (!isset($r->type) || !isset($r->description)){
            return self::jsonError('missing values');
        }

        if (!TypeActivite::query()->where('id', $r->type)->exists()){
            return self::jsonError('bad request type');
        }

        $d = new Demande();
        $d->utilisateur = self::getUser()->id;
        $d->description = $r->description;
        $d->type = $r->type;
        $d->save();
        return self::jsonOk();
    }

    function delete(Request $r)
    {
        if (!isset($r->id)){
            return self::jsonError('missing values');
        }

        if (!Demande::query()->where('id', $r->id)->exists()){
            return self::jsonError('request do not exists');
        }

        Demande::query()->where('id', $r->id)->delete();
        return self::jsonOk();
    }

    function statusGet(Request $r)
    {
        if (!isset($r->id)){
            return self::jsonError('missing id value');
        }
        return Demande::query()->where('id', $r->id)->get('statut');
    }

    function statusPost(Request $r){
        if (!isset($r->id) || !isset($r->status)){
            return self::jsonError('missing id value');
        }
        Demande::query()->where('id', $r->id)->update(['statut' => $r->status]);
        return self::jsonOk();
    }
}
