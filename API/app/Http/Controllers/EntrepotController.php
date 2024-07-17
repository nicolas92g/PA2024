<?php

namespace App\Http\Controllers;

use App\Models\Entrepot;
use Illuminate\Http\Request;

class EntrepotController extends Controller
{
    function list(){
        return Entrepot::query()->join('addresse', 'entrepot.addresse', '=', 'addresse.id')
            ->select('entrepot.*', 'addresse.premiere_ligne', 'addresse.code_postal', 'addresse.ville')
            ->get();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Entrepot::class, ["name" => "nom"], true);
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Entrepot::class);
    }
}
