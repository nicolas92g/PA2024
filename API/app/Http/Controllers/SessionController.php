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
            ['name' => 'nom', 'place' => 'emplacement', 'time' => 'horaire', 'description' => 'description', 'activity' => 'activite']
        );
    }

    public function delete(Request $request){
        return $this->deleteFunctionTemplate($request, Session::class);
    }
}
