<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\TypeActivite;
use Illuminate\Http\Request;

class ActiviteController extends Controller
{
    function list(){
        return Activite::query()->join('type_activite','type_activite.id','=','activite.type')->select('activite.*','type_activite.nom as nom_type')->get();
    }

    function create(Request $r){

        if (isset($r->type) && !TypeActivite::query()->where('id', $r->type)->exists()){
            return self::jsonError('type does not exist');
        }

        return $this->createFunctionTemplate($r, Activite::class, ["name" => "nom", "description" => "description", "type" => "type"]);
    }

    function delete(Request $r){
        return self::deleteFunctionTemplate($r, Activite::class);
    }
}
