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
        return $this->createFunctionTemplate($request, Camion::class, ["brand" => "marque", "model" => "modele", "year" => "annee", 'registration' => 'immatriculation', "annexe" => "annexe"]);
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Camion::class);
    }
}
