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
Route::post('/addAdmin', [\App\Http\Controllers\AuthController::class, "addAdmin"])->middleware(['auth:sanctum', 'ability:admin']);

Route::get('/users', [\App\Http\Controllers\UtilisateurController::class, "list"])->middleware(['auth:sanctum', 'ability:admin,benevole']);
Route::get('/volunteers', [\App\Http\Controllers\UtilisateurController::class, "listVolunteers"])->middleware(['auth:sanctum', 'ability:admin,benevole']);
Route::get('/beneficiaries', [\App\Http\Controllers\UtilisateurController::class, "listBeneficiaries"])->middleware(['auth:sanctum', 'ability:admin,benevole']);

Route::get('/user/roles', [\App\Http\Controllers\UtilisateurController::class, "roles"])->middleware(['auth:sanctum']);
Route::post('/user/roles/add', [\App\Http\Controllers\RoleController::class, "add"])->middleware(['auth:sanctum']);
Route::post('/user/roles/remove', [\App\Http\Controllers\RoleController::class, "remove"])->middleware(['auth:sanctum']);

Route::get('/user/abilities', [\App\Http\Controllers\AUneCompetenceController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/user/abilities/add', [\App\Http\Controllers\AUneCompetenceController::class, "add"])->middleware(['auth:sanctum']);
Route::post('/user/abilities/remove', [\App\Http\Controllers\AUneCompetenceController::class, "remove"])->middleware(['auth:sanctum']);

Route::get('/ability/list', [\App\Http\Controllers\CompetenceController::class, "list"]);
Route::post('/ability/create', [\App\Http\Controllers\CompetenceController::class, "create"])->middleware(['auth:sanctum', 'ability:admin,benevole']);
Route::post('/ability/delete', [\App\Http\Controllers\CompetenceController::class, "delete"])->middleware(['auth:sanctum', 'ability:admin']);

Route::get('/request/list', [\App\Http\Controllers\DemandeController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/request/create', [\App\Http\Controllers\DemandeController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/request/delete', [\App\Http\Controllers\DemandeController::class, "delete"])->middleware(['auth:sanctum']);
Route::get('/request/status', [\App\Http\Controllers\DemandeController::class, "statusGet"])->middleware(['auth:sanctum']);
Route::post('/request/status', [\App\Http\Controllers\DemandeController::class, "statusPost"])->middleware(['auth:sanctum']);

Route::get('/activityType/list', [\App\Http\Controllers\TypeActiviteController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/activityType/create', [\App\Http\Controllers\TypeActiviteController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/activityType/delete', [\App\Http\Controllers\TypeActiviteController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/activity/list', [\App\Http\Controllers\ActiviteController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/activity/create', [\App\Http\Controllers\ActiviteController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/activity/delete', [\App\Http\Controllers\ActiviteController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/session/list', [\App\Http\Controllers\SessionController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/session/create', [\App\Http\Controllers\SessionController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/session/delete', [\App\Http\Controllers\SessionController::class, "delete"])->middleware(['auth:sanctum']);
Route::get('/session/size', [\App\Http\Controllers\SessionController::class, "size"])->middleware(['auth:sanctum']);
Route::get('/session/maraudes', [\App\Http\Controllers\SessionController::class, "listMaraudes"])->middleware(['auth:sanctum']);

Route::get('/benefit/list', [\App\Http\Controllers\BeneficieController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/benefit/create', [\App\Http\Controllers\BeneficieController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/benefit/delete', [\App\Http\Controllers\BeneficieController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/intervenes/list', [\App\Http\Controllers\IntervientController ::class, "list"])->middleware(['auth:sanctum']);
Route::post('/intervenes/create', [\App\Http\Controllers\IntervientController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/intervenes/delete', [\App\Http\Controllers\IntervientController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/truck/list', [\App\Http\Controllers\CamionController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/truck/create', [\App\Http\Controllers\CamionController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/truck/delete', [\App\Http\Controllers\CamionController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/annexe/list', [\App\Http\Controllers\AnnexeController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/annexe/create', [\App\Http\Controllers\AnnexeController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/annexe/delete', [\App\Http\Controllers\AnnexeController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/entrepot/list', [\App\Http\Controllers\EntrepotController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/entrepot/create', [\App\Http\Controllers\EntrepotController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/entrepot/delete', [\App\Http\Controllers\EntrepotController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/fournisseur/list', [\App\Http\Controllers\FournisseurController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/fournisseur/create', [\App\Http\Controllers\FournisseurController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/fournisseur/delete', [\App\Http\Controllers\FournisseurController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/product/list', [\App\Http\Controllers\ProduitController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/product/create', [\App\Http\Controllers\ProduitController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/product/delete', [\App\Http\Controllers\ProduitController::class, "delete"])->middleware(['auth:sanctum']);
Route::post('/product/maraude', [\App\Http\Controllers\ProduitController::class, "setMaraude"])->middleware(['auth:sanctum']);
Route::post('/product/stock', [\App\Http\Controllers\ProduitController::class, "stock"])->middleware(['auth:sanctum']);

Route::get('/ticket/list', [\App\Http\Controllers\TicketController::class, "listTickets"])->middleware(['auth:sanctum']);
Route::post('/ticket/create', [\App\Http\Controllers\TicketController::class, "createTicket"])->middleware(['auth:sanctum']);
Route::post('/ticket/updateState', [\App\Http\Controllers\TicketController::class, "updateState"])->middleware(['auth:sanctum']);

Route::get('/ticketResponse/list', [\App\Http\Controllers\TicketController::class, "listResponses"])->middleware(['auth:sanctum']);
Route::post('/ticketResponse/create', [\App\Http\Controllers\TicketController::class, "createResponse"])->middleware(['auth:sanctum']);

Route::get('/ramassage/list', [\App\Http\Controllers\RamassageController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/ramassage/create', [\App\Http\Controllers\RamassageController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/ramassage/delete', [\App\Http\Controllers\RamassageController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/ramasse/list', [\App\Http\Controllers\RamasseController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/ramasse/create', [\App\Http\Controllers\RamasseController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/ramasse/delete', [\App\Http\Controllers\RamasseController::class, "delete"])->middleware(['auth:sanctum']);

Route::get('/etape/list', [\App\Http\Controllers\EtapeController::class, "list"])->middleware(['auth:sanctum']);
Route::post('/etape/create', [\App\Http\Controllers\EtapeController::class, "create"])->middleware(['auth:sanctum']);
Route::post('/etape/delete', [\App\Http\Controllers\EtapeController::class, "delete"])->middleware(['auth:sanctum']);
