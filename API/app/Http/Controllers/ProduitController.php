<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    function list(){
        return DB::table('produit')
            ->join('fournisseur', 'fournisseur.id', '=', 'produit.fournisseur')
            ->select('produit.*', 'fournisseur.nom as fournisseur_nom')->get();
    }

    function create(Request $request){
        return $this->createFunctionTemplate($request, Produit::class,
            ["quantity" => "quantite", "dateLimit" => "date_limite", "name" => "nom", "description" => "description", "fournisseur" => "fournisseur", "entrepot" => "entrepot"]
        );
    }

    function delete(Request $request)
    {
        return $this->deleteFunctionTemplate($request, Produit::class);
    }
}
