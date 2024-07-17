<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Intervient;
use Illuminate\Http\Request;

class EtapeController extends Controller
{
    function list(){
        return Etape::query()->join('addresse', 'etape.addresse', '=', 'addresse.id')
            ->select('etape.*', 'addresse.premiere_ligne', 'addresse.code_postal', 'addresse.ville')
            ->get();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Etape::class, ["maraude" => "maraude"], true);
    }

    function delete(Request $r)
    {
        if (!isset($r->maraude) || !isset($r->addresse)){
            return self::jsonError('l\'addresse ou la maraude est manquante');
        }

        Etape::query()->where('maraude', $r->maraude)->where('addresse', $r->addresse)->delete();
        return self::jsonOk();
    }
}
