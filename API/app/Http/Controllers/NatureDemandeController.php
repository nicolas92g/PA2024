<?php

namespace App\Http\Controllers;

use App\Models\NatureDemande;
use Illuminate\Http\Request;

class NatureDemandeController extends Controller
{
    function list(){
        return NatureDemande::All();
    }

    function create(Request $r){
        if (!isset($r->name)){
            return self::jsonError("Missing name input");
        }

        $newl = new NatureDemande();
        $newl->nom = $r->name;
        $newl->save();

        return self::jsonOk();
    }

    function delete(Request $r)
    {
        if (!isset($r->id)){
            return self::jsonError("Missing id input");
        }

        if (!NatureDemande::query()->where('id', $r->id)->exists()){
            return self::jsonError('this id do not exists');
        }

        NatureDemande::query()->where('id', $r->id)->delete();
        return self::jsonOk();
    }
}
