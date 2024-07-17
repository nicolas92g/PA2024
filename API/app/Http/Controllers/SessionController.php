<?php

namespace App\Http\Controllers;

use App\Models\Beneficie ;
use App\Models\Produit;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function list(){
        return Session::query()
            ->join('activite', 'session.activite', '=', 'activite.id')
            ->join('type_activite', 'activite.type', '=', 'type_activite.id')
            ->select(['session.*', 'type_activite.nom as typeActivite', 'activite.nom as activiteNom'])->get();
    }
    public function create(Request $request){
        return $this->createFunctionTemplate($request, Session::class,
            ['name' => 'nom', 'place' => 'emplacement', 'time' => 'horaire', 'description' => 'description', 'activity' => 'activite'],
            false,
            [],
            ['arrival' => 'emplacement_arrive', 'end' => 'horaire_fin', 'entrepot' => 'entrepot', 'max' => 'max_participants', 'quantity' => 'quantite', 'truck' => 'camion']
        );
    }

    public function delete(Request $request){

        Produit::query()->where('maraude', '=', $request->id)->delete();

        return $this->deleteFunctionTemplate($request, Session::class);
    }

    public function size(Request $r){
        if (!isset($r->session_id)){
            return self::jsonError('session_id is missing');
        }

        return response()->json(['size' => Beneficie::query()->where('session', $r->session_id)->count()]);
    }

    public function listMaraudes(Request $request){
        return Session::query()->where('activite', "=", 1)->get();
    }
}
