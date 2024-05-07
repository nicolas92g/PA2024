<?php

namespace App\Http\Controllers;

use App\Models\Beneficie;
use Illuminate\Http\Request;

class BeneficieController extends Controller
{
    function list(){
        return Beneficie::all();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Beneficie::class,
            ['user' => 'beneficiaire', 'session' => 'session']
        );
    }

    function delete(Request $request){
        return $this->deleteFunctionTemplate($request, Beneficie::class);
    }
}
