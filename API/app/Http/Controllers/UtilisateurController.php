<?php

namespace App\Http\Controllers;

use App\Models\EstUn;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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
