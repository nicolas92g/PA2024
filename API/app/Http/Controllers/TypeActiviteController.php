<?php

namespace App\Http\Controllers;

use App\Models\TypeActivite;
use Illuminate\Http\Request;

class TypeActiviteController extends Controller
{
    function list(){
        return TypeActivite::All();
    }

    function create(Request $r){
        return $this->createFunctionTemplate($r, TypeActivite::class, ["name" => "nom", "description" => "description"]);
    }

    function delete(Request $r){
        return self::deleteFunctionTemplate($r, TypeActivite::class);
    }
}
