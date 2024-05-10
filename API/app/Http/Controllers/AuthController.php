<?php

namespace App\Http\Controllers;

use App\Models\Addresse;
use App\Models\AUneCompetence;
use App\Models\EstUn;
use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private static function hashPassword($password, $salt) : string
    {
        return hash('sha256', $salt . $password);
    }

    public function register(Request $request) : JsonResponse
    {
        if (
            !isset($request->email) ||
            !isset($request->firstName) ||
            !isset($request->lastName) ||
            !isset($request->addressLine) ||
            !isset($request->addressCode) ||
            !isset($request->addressCity)
        ){
            return self::jsonError('there is data missing in order to register');
        }

        if (strlen($request->password) < 8){
            return self::jsonError('password must have at least 8 characters');
        }

        if ((int)$request->addressCode < 10000 || (int)$request->addressCode > 99999){
            return self::jsonError('Bad address zip code');
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return self::jsonError('Invalid email address');
        }

        if (Utilisateur::query()->where("mail", $request->email)->exists()){
            return self::jsonError('email address is already used', 409);
        }

        $address = new Addresse();
        $address->premiere_ligne = $request->addressLine;
        $address->code_postal = $request->addressCode;
        $address->ville = $request->addressCity;
        $address->save();

        $user = new Utilisateur();
        $user->prenom = $request->firstName;
        $user->nom = $request->lastName;
        $user->mail = $request->email;
        $user->sel = Str::random(10);
        $user->mot_de_passe_hash = self::hashPassword($request->password, $user->sel);
        $user->addresse = $address->id;
        $user->mail_verifie = true; //TODO envoyer un mail de confirmation
        $user->save();

        return response()->json(['msg' => 'your request was executed successfully', 'id' => $user->id]);
    }

    public function registerVolunteer(Request $request) : JsonResponse
    {

        $registerResult = $this->register($request);
        if ($registerResult->status() !== 200) return $registerResult;

        $user = Utilisateur::query()->where('mail', $request->email)->first()->id;

        if (isset($request->abilities)){
            $abilities = json_decode($request->abilities);

            foreach ($abilities as $ability){
                $r = new AUneCompetence();
                $r->utilisateur = $user;
                $r->competence = $ability;
                $r->save();
            }
        }

        $rel = new EstUn();
        $rel->utilisateur = $user;
        $rel->role = 2;
        $rel->save();

        return response()->json(['msg' => 'your request was executed successfully', 'id' => $user->id]);
    }

    public function login(Request $request) : JsonResponse
    {
        $user = Utilisateur::query()->where("mail", $request->email)->get();

        $errorMsg = 'Invalid Mail or Password';
        if (!isset($user[0])){
            return self::jsonError($errorMsg, 401);
        }

        $user = $user[0];

        if (!$user->mail_verifie){
            return self::jsonError('you have to verify your email address first', 403);
        }

        if ($user->mot_de_passe_hash === self::hashPassword($request->password, $user->sel)) {
            //delete previous token
            $user->tokens()->delete();

            //get user roles
            $roles = [];
            foreach ($user->roles()->get(['nom']) as $role){
                array_push($roles, $role['nom']);
            }

            $token = $user->createToken("login", $roles);

            $user->derniere_connexion = now();
            $user->save();

            return response()->json(["token" => $token->plainTextToken]);
        }
        return self::jsonError($errorMsg, 401);
    }

    public function logout() : JsonResponse
    {
        self::getUser()->tokens()->delete();
        return self::jsonOk();
    }

    public function unauthenticated() : JsonResponse
    {
        return self::jsonError('Authentication failed', 401);
    }
}
