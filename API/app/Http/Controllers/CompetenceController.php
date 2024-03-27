<?php

namespace App\Http\Controllers;

use App\Models\AUneCompetence;
use App\Models\Competence;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    function list(){
        return Competence::All();
    }

    function create(Request $request){
        if (!isset($request->name) || !isset($request->description)){
            return self::jsonError("Missing name or description input");
        }

        $ability = new Competence();
        $ability->nom = $request->name;
        $ability->description = $request->description;
        $ability->save();

        return self::jsonOk();
    }

    function delete(Request $request){
        if (!isset($request->id)){
            return self::jsonError("Missing name or description input");
        }

        if (!Competence::query()->where('id', $request->id)->exists()){
            return self::jsonError("There is no ability with this id");
        }

        Competence::query()->where('id', $request->id)->delete();
        return self::jsonOk();
    }
}
