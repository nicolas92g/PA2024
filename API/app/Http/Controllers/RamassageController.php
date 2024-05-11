<?php

namespace App\Http\Controllers;

use App\Models\Ramassage;
use App\Models\Ramasse;
use Illuminate\Http\Request;

class RamassageController extends Controller
{
    function list(){
        return Ramassage::query()
            ->join('utilisateur','ramassage.utilisateur','=','utilisateur.id')
            ->join('camion','ramassage.camion','=','camion.id')
            ->select('ramassage.*','utilisateur.nom as nomUtilisateur', 'utilisateur.prenom as prenomUtilisateur', 'camion.immatriculation as camionId')
            ->get();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Ramassage::class,
            ['time' => 'horaire_debut', 'truck' => 'camion', 'user' => 'utilisateur'], false, [], [],
            true
        );
    }

    function delete(Request $request)
    {
        Ramasse::query()->where('ramassage', '=', $request->id)->delete();
        return $this->deleteFunctionTemplate($request, Ramassage::class);
    }
}
