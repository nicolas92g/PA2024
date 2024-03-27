<?php

namespace App\Http\Controllers;

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
        return response()->json(['error' => $errMsg], $status);
    }

    protected static function jsonOk($msg = 'your request was executed successfully') : jsonResponse
    {
        return response()->json(['msg' => $msg]);
    }

    protected function createFunctionTemplate(Request $r, $class, $inputs){
        foreach ($inputs as $key => $value){
            if (!isset($r->$key)){
                return self::jsonError('there is a missing input : ' . $key);
            }
        }

        $c = new ReflectionClass($class);

        try {
            $obj = $c->newInstance();
        }catch(\Exception $e){
            return self::jsonError('An error occured', 500);
        }

        foreach ($inputs as $key => $value){
            $obj->$value = $r->$key;
        }

        $obj->save();

        return self::jsonOk();
    }

    protected static function deleteFunctionTemplate(Request $r, $class){

        if (!isset($r->id)){
            return self::jsonError('id is missing');
        }

        $c = new ReflectionClass($class);

        try {
            $query = $c->getMethod('query')->invoke(null)->where('id', $r->id);
        }catch(\Exception $e){
            return self::jsonError('An error occured', 500);
        }

        if (!$query->exists()){
            return self::jsonError('This id does not exists');
        }

        $query->delete();

        return self::jsonOk();
    }
}
