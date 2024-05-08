<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function list(){
        return Session::all();
    }
    public function create(Request $request){
        return $this->createFunctionTemplate($request, Session::class,
            ['name' => 'nom', 'place' => 'emplacement', 'time' => 'horaire', 'description' => 'description', 'activity' => 'activite'],
            false,
            [],
            ['arrival' => 'emplacement_arrive', 'end' => 'horaire_fin', 'product' => 'produit', 'entrepot' => 'entrepot', 'max' => 'max_participants', 'quantity' => 'quantite']
        );
    }

    public function delete(Request $request){
        return $this->deleteFunctionTemplate($request, Session::class);
    }
}
