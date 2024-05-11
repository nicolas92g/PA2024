<?php

namespace App\Http\Controllers;

use App\Models\Ramassage;
use App\Models\Ramasse;
use Illuminate\Http\Request;

class RamasseController extends Controller
{
    function list(){
        return Ramasse::all();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Ramasse::class,
            ['product' => 'produit', 'ramassage' => 'ramassage', 'order' => 'ordre']
        );
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Ramasse::class);
    }
}
