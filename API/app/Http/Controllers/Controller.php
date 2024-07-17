<?php

namespace App\Http\Controllers;

use App\Models\Addresse;
use App\Models\TypeActivite;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use ReflectionClass;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected static function getUser() : Authenticatable
    {
        return Auth::guard('sanctum')->user();
    }

    protected static function jsonError($errMsg, $status = 400) : jsonResponse
    {
        return response()->json(['msg' => $errMsg, 'status' => $status], $status);
    }

    protected static function jsonOk($msg = 'Votre requete à été éxécuté avec succès') : jsonResponse
    {
        return response()->json(['msg' => $msg, 'status' => 200]);
    }

    protected function createFunctionTemplate(Request $r, $class, $inputs, $address = false, $constants = [], $options = [], $returnId = false){
        foreach ($inputs as $key => $value){
            if (!isset($r->$key)){
                return self::jsonError('Il y a une entrée manquante : ' . $key);
            }
        }

        $a = new Addresse();
        if ($address){
            if (!isset($r->addressLine) || !isset($r->addressCode) || !isset($r->addressCity)){
                return self::jsonError('Il manque des éléments de l\'adresse');
            }
            $a->premiere_ligne = $r->addressLine;
            $a->code_postal = $r->addressCode;
            $a->ville = $r->addressCity;
            $a->save();
        }

        $c = new ReflectionClass($class);

        try {
            $obj = $c->newInstance();
        }catch(\Exception $e){
            return self::jsonError('Une erreur est survenue', 500);
        }

        foreach ($inputs as $key => $value){
            if ($r->$key !== "none")
                $obj->$value = $r->$key;
        }

        foreach ($constants as $key => $value){
            $obj->$key = $value;
        }

        foreach ($options as $key => $value){
            if (isset($r->$key))
                $obj->$value = $r->$key;
        }

        if ($address){
            $obj->addresse = $a->id;
        }

        $obj->save();

        if ($returnId){
            return response()->json(['msg' => "Votre requete à été éxécuté avec succès", 'id' => $obj->id]);
        }

        return self::jsonOk();
    }

    protected static function deleteFunctionTemplate(Request $r, $class){

        if (!isset($r->id)){
            return self::jsonError('L\'id est manquant');
        }

        $c = new ReflectionClass($class);

        try {
            $query = $c->getMethod('query')->invoke(null)->where('id', $r->id);
        }catch(\Exception $e){
            return self::jsonError('Une erreur est survenue', 500);
        }

        if (!$query->exists()){
            return self::jsonError('Cet ID n\'existe pas');
        }

        $query->delete();

        return self::jsonOk();
    }
}
