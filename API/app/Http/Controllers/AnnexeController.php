<?php

namespace App\Http\Controllers;

use App\Models\Annexe;
use Illuminate\Http\Request;

class AnnexeController extends Controller
{
    public function list(){
        return Annexe::query()
            ->join('addresse', 'annexe.addresse', '=', 'addresse.id')
            ->select('annexe.*', 'addresse.premiere_ligne', 'addresse.code_postal', 'addresse.ville')
            ->get();
    }

    public function create(Request $request){
        return $this->createFunctionTemplate($request, Annexe::class, ["name" => "nom"], true);
    }

    public function delete(Request $request){
        return $this->deleteFunctionTemplate($request, Annexe::class);
    }
}
