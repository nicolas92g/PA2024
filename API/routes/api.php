<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [\App\Http\Controllers\AuthController::class, "register"]);
Route::post('/registerVolunteer', [\App\Http\Controllers\AuthController::class, "registerVolunteer"]);
Route::post( '/login', [\App\Http\Controllers\AuthController::class, "login"]);
Route::get(null, [\App\Http\Controllers\AuthController::class, "unauthenticated"])->name('unauthenticated');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, "logout"])->middleware(['auth:sanctum']);

Route::get('/myself', [\App\Http\Controllers\UtilisateurController::class, "myself"])->middleware(['auth:sanctum']);

Route::get('/users', [\App\Http\Controllers\UtilisateurController::class, "list"])->middleware(['auth:sanctum', 'ability:admin,content']);

Route::get('/user/roles', [\App\Http\Controllers\UtilisateurController::class, "roles"])->middleware(['auth:sanctum']);
Route::post('/user/roles/add', [\App\Http\Controllers\RoleController::class, "add"])->middleware(['auth:sanctum']);
Route::post('/user/roles/remove', [\App\Http\Controllers\RoleController::class, "remove"])->middleware(['auth:sanctum']);

Route::get('/user/abilities', [\App\Http\Controllers\AUneCompetenceController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/user/abilities/add', [\App\Http\Controllers\AUneCompetenceController::class, "add"])->middleware(['auth:sanctum']);
Route::post('/user/abilities/remove', [\App\Http\Controllers\AUneCompetenceController::class, "remove"])->middleware(['auth:sanctum']);

Route::get('/ability/list', [\App\Http\Controllers\CompetenceController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/ability/create', [\App\Http\Controllers\CompetenceController::class, "create"])->middleware(['auth:sanctum', 'ability:admin,content']);
Route::post('/ability/delete', [\App\Http\Controllers\CompetenceController::class, "delete"])->middleware(['auth:sanctum', 'ability:admin']);

Route::get('/request/list', [\App\Http\Controllers\DemandeController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/request/create', [\App\Http\Controllers\DemandeController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/request/delete', [\App\Http\Controllers\DemandeController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/activityType/list', [\App\Http\Controllers\TypeActiviteController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/activityType/create', [\App\Http\Controllers\TypeActiviteController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/activityType/delete', [\App\Http\Controllers\TypeActiviteController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/activity/list', [\App\Http\Controllers\ActiviteController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/activity/create', [\App\Http\Controllers\ActiviteController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/activity/delete', [\App\Http\Controllers\ActiviteController::class, "delete"])->middleware(['auth:sanctum']);
