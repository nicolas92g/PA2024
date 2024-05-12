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
        if (!isset($r->beneficiaire) || !isset($r->session_id)){
            return self::jsonError('beneficiaire or session_id is missing');
        }

        Beneficie::query()->where('beneficiaire', $r->beneficiaire)->where('session', $r->session_id)->delete();
        return self::jsonOk();
    }
}
