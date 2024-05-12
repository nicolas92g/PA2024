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

    function delete(Request $r){
        if (!isset($r->intervenant) || !isset($r->session_id)){
            return self::jsonError('intervenant or session_id is missing');
        }

        Intervient::query()->where('intervenant', $r->intervenant)->where('session', $r->session_id)->delete();
        return self::jsonOk();
    }
}
