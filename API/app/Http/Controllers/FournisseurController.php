<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    function list(){
        return Fournisseur::all();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Fournisseur::class, ["name" => "nom"], true);
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Fournisseur::class);
    }
}
