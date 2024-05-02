<?php

namespace App\Http\Controllers;

use App\Models\Camion;
use Illuminate\Http\Request;

class CamionController extends Controller
{
    function list(){
        return Camion::all();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Camion::class, ["modele" => "modele", "weightLimit" => "limite_poids", "annexe" => "annexe"]);
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Camion::class);
    }
}
