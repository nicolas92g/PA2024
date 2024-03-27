<?php

namespace App\Http\Controllers;

use App\Models\EstUn;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function add(Request $request){
        if (!isset($request->user) || !isset($request->role)){
            return self::jsonError("Missing user or role input");
        }

        if (!Utilisateur::exists($request->user)){
            return self::jsonError('user input is not valid');
        }

        $rel = new EstUn();
        $rel->utilisateur = (int)$request->user;

        $user = Utilisateur::getFromId($request->user);

        switch ($request->role){
            case "admin":
                if ($user->isAdmin()) return self::jsonError('User is already admin');
                $rel->role = 1;
                break;
            case "benevole":
                if ($user->isBenevole()) return self::jsonError('User is already benevole');
                $rel->role = 2;
                break;
            default:
                return self::jsonError('role input is not valid');
        }

        $rel->save();
        return self::jsonOk();
    }

    function remove(Request $request){
        if (!isset($request->user) || !isset($request->role)){
            return self::jsonError("Missing user or role input");
        }

        if (!Utilisateur::exists($request->user)){
            return self::jsonError('user input is not valid');
        }

        $user = Utilisateur::getFromId($request->user);

        switch ($request->role){
            case "admin":
                if (!$user->isAdmin()) return self::jsonError('User is not an admin');
                EstUn::query()->where('utilisateur', $request->user)->where('role', 1)->delete();
                break;
            case "benevole":
                if (!$user->isBenevole()) return self::jsonError('User is not a benevole');
                EstUn::query()->where('utilisateur', $request->user)->where('role', 2)->delete();
                break;
            default:
                return self::jsonError('role input is not valid');
        }

        return self::jsonOk();
    }
}
