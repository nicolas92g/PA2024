<?php

namespace App\Http\Controllers;

use App\Models\Beneficie;
use App\Models\Intervient;
use Illuminate\Http\Request;

class IntervientController extends Controller
{
    function list(){
        return Intervient::all();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Intervient::class,
            ['user' => 'intervenant', 'session' => 'session']
        );
    }

    function delete(Request $request){
        return $this->deleteFunctionTemplate($request, Intervient::class);
    }
}
