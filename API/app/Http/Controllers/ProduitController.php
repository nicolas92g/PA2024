<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Session;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    function list(){
        return DB::table('produit')
            ->join('fournisseur', 'fournisseur.id', '=', 'produit.fournisseur')
            ->leftJoin('entrepot', 'entrepot.id', '=', 'produit.entrepot')
            ->leftJoin('ramasse', 'ramasse.produit', '=', 'produit.id')
            ->select('produit.*', 'fournisseur.nom as fournisseur_nom', 'entrepot.nom as entrepot_nom', 'ramasse.ramassage')->get();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Produit::class,
            ["quantity" => "quantite", "name" => "nom", "description" => "description", "fournisseur" => "fournisseur", "entrepot" => "entrepot"],
            false,
            [],
            ["dateLimit" => "date_limite", "etagere" => "etagere"]
        );
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Produit::class);
    }

    function setMaraude(Request $request)
    {
        if (!isset($request->id) && !isset($request->maraude)){
            return self::jsonError("Il manque des valeurs");
        }

        if ($request->maraude == 'null'){
            Produit::query()->where('id', $request->id)->update(['maraude' => null]);
            return self::jsonOk();
        }

        if (!Session::query()->where("id", "=", $request->maraude)->exists()){
            return self::jsonError("La marause n'existe pas");
        }

        Produit::query()->where('id', $request->id)->update(['maraude' => $request->maraude]);
        return self::jsonOk();
    }

    function stock(request $request){
        if (!isset($request->entrepot) && !isset($request->etagere) && !isset($request->id)){
            return self::jsonError("Il manque des valeurs");
        }

        $p = Produit::query()->where('id', '=', $request->id)->first();
        $p->entrepot = $request->entrepot;
        $p->etagere = $request->etagere;
        $p->save();
        return self::jsonOk();
    }
}
