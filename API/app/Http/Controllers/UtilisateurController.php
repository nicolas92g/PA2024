<?php

namespace App\Http\Controllers;

use App\Models\EstUn;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UtilisateurController extends Controller
{
    function myself()
    {
        return parent::getUser();
    }

    function list()
    {
        return Utilisateur::All(['id', 'prenom', 'nom', 'mail', 'mail_verifie', 'derniere_connexion', 'addresse']);
    }

    function listBeneficiaries()
    {
        return DB::table('utilisateur')
            ->leftJoin('est_un', 'utilisateur.id', '=', 'est_un.utilisateur')
            ->whereNull('est_un.role')
            ->select('utilisateur.*')
            ->get();
    }

    function listVolunteers()
    {
        return DB::table('utilisateur')
            ->join('est_un', 'utilisateur.id', '=', 'est_un.utilisateur')
            ->join('role', 'est_un.role', '=', 'role.id')
            ->join('addresse', 'utilisateur.addresse', '=', 'addresse.id')
            ->where('role.nom', '=', 'benevole')
            ->select('utilisateur.*', 'role.nom', 'addresse.premiere_ligne', 'addresse.code_postal', 'addresse.ville')
            ->get();
    }

    function roles(Request $request)
    {
        if (!isset($request->id)){
            return parent::getUser()->roles()->get(['nom']);
        }

        $query = Utilisateur::query()->where('id', $request->id);
        if ($query->exists()){
            return $query->get()[0]->roles()->get(['nom']);
        }
        return self::jsonError('there is no user with that id');
    }


}
