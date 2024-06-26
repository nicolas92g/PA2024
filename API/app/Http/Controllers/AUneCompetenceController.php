<?php

namespace App\Http\Controllers;

use App\Models\AUneCompetence;
use App\Models\Competence;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class AUneCompetenceController extends Controller
{
    function list(Request $r){
        $id = $r->id ?? self::getUser()->id;
        if (!Utilisateur::exists($id)) return self::jsonError('User do not exists');
        return AUneCompetence::query()->where('utilisateur', $id)->get();
    }

    function add(Request $r){
        if (!isset($r->id)){
            return self::jsonError('ability id is missing');
        }

        if (!Competence::query()->where('id', $r->id)->exists()){
            return self::jsonError('ability id do not exists');
        }

        if (AUneCompetence::query()->where('utilisateur', self::getUser()->id)->where('competence', $r->id)->exists()){
            return self::jsonError('user already have this ability');
        }

        $rel = new AUneCompetence();
        $rel->utilisateur = self::getUser()->id;
        $rel->competence = $r->id;
        $rel->save();

        return self::jsonOk();
    }

    function remove(Request $r){
        if (!isset($r->id)){
            return self::jsonError('ability id is missing');
        }

        if (!Competence::query()->where('id', $r->id)->exists()){
            return self::jsonError('ability id do not exists');
        }

        if (!AUneCompetence::query()->where('utilisateur', self::getUser()->id)->where('competence', $r->id)->exists()){
            return self::jsonError('user do not have this ability');
        }

        AUneCompetence::query()->where('utilisateur', self::getUser()->id)->where('competence', $r->id)->delete();

        return self::jsonOk();
    }
}
