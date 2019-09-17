<?php
use Illuminate\Http\Request;
use App\User;

/*php
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//auth
Route::apiResource('login', 'Auth\LoginController');
Route::post('register', 'Auth\RegisterController@store');
/////Hajar
Route::group(['middleware'=>'roles','roles' => ['admin']],function(){

});

Route::get('/mark-all-read/{user}',function(User $user){
    $user->unreadNotifications->markAsRead();
});
Route::get('notifications', 'API\NotificationsController@notifications');

Route::apiResource('major', 'API\MajorController');
Route::get('majorP', 'API\MajorController@indexP');
Route::apiResource('demandeur', 'API\DemandeurController');
Route::apiResource('hopital', 'API\HopitalController');
Route::apiResource('service', 'API\ServiceController');
Route::get('serviceP', 'API\ServiceController@indexP');
Route::apiResource('coordinateur', 'API\CoordinateurController');
Route::apiResource('login', 'Auth\LoginController');
Route::apiResource('urgencenormaux', 'API\UrgenceNormauxController');
Route::apiResource('urgencenormaux1', 'API\UrgenceNormauxController1');
Route::post('sendbran', 'API\UrgenceNormauxController1@branAffectation');
Route::get('test1', 'API\UrgenceNormauxController1@index');
Route::get('findBran', 'API\BrancardierController@search');
Route::get('findusers_v', 'API\BrancardierController@search_v');
Route::get('findusers_nv', 'API\BrancardierController@search_nv');
Route::get('findService', 'API\ServiceController@search');
Route::get('findMajor', 'API\MajorController@search');
Route::get('findCoordinateur', 'API\CoordinateurController@search');
Route::get('findDemandeur', 'API\DemandeurController@search');
Route::get('UrgenceId', 'API\ServiceController@UrgenceId');
Route::get('isUrg', 'API\ServiceController@isUrg');
Route::get('brancardierMajor', 'API\BrancardierController@brancardierMajor');


///Toufiq
Route::get('services_non_fix', 'API\ServiceController@indexAffectationNonFix');
Route::get('services_fix', 'API\ServiceController@indexAffectationFix');
Route::get('services_urgence', 'API\ServiceController@indexAffectationUrgence');
///Me
Route::put('brancardier/{id}', 'API\BrancardierController@updateUser');
Route::apiResources(['user' => 'API\UserController']);
Route::get('profileAuth', 'API\BrancardierController@profileAuth');
//Route::get('profile', 'API\UserController@profile');
Route::get('findBran', 'API\BrancardierController@search');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('users_v', 'API\BrancardierController@index');
Route::get('brancardier', 'API\BrancardierController@index2');
Route::get('brancardierTemp', 'API\BrancardierController@indexTemp');
Route::get('users_nv', 'API\BrancardierController@index3');
Route::get('profile/{id}', 'API\BrancardierController@index4');
Route::get('brancardier/{id}', 'API\BrancardierController@index5');
Route::put('updateProfile/{id}', 'API\BrancardierController@updateProfile');
Route::post('selectedItem', 'API\BrancardierController@selectedItem');
Route::delete('brancardier/{id}', 'API\BrancardierController@destroy');
Route::post('brancardier', 'API\BrancardierController@store');
Route::post('CreateUser', 'API\BrancardierController@storeUser');
Route::put('updateUser/{id}', 'API\BrancardierController@updateUser2'   );

Route::apiResources(['etat' => 'API\EtatController']);




//affecations
Route::post('gestionAffecationsMan', 'API\BrancardierController@gestionAffecationsMan');
Route::get('affectationNonUrgence/{id}', 'API\BrancardierController@affectationNonUrgence');  
Route::get('affectationUrgence/{id}', 'API\BrancardierController@affectationUrgence'); 
Route::post('UpdateAffectation', 'API\BrancardierController@UpdateAffectation');
Route::get('affectationBrancardier', 'API\BrancardierController@affectationBrancardier'); 


Route::get('affectationNonUrgenceBackWeek/{id}/{n}/{n2}', 'API\BrancardierController@affectationNonUrgenceBackWeek');  
Route::get('affectationUrgenceBackWeek/{id}/{n}/{n2}', 'API\BrancardierController@affectationUrgenceBackWeek'); 
Route::get('affectationBrancardierBackWeek/{n}/{n2}', 'API\BrancardierController@affectationBrancardierBackWeek'); 
Route::get('affectationBrancardierNextWeek/{n}/{n2}', 'API\BrancardierController@affectationBrancardierNextWeek'); 
Route::get('affectationNonUrgenceNextWeek/{id}/{n}/{n2}', 'API\BrancardierController@affectationNonUrgenceNextWeek');  
Route::get('affectationUrgenceNextWeek/{id}/{n}/{n2}', 'API\BrancardierController@affectationUrgenceNextWeek');


//Demandes 
Route::get('filtreEtat/{id}', 'API\DemandeController@filtreEtat');
Route::get('filtreEtatMajor/{id}', 'API\DemandeController@filtreEtatMajor');
Route::get('filtreEtatDemandeurs/{id}', 'API\DemandeController@filtreEtatDemandeurs');

Route::get('filtreEtatBrancardier/{id}', 'API\DemandeController@filtreEtatBrancardier');
Route::get('demandesBrancardier', 'API\DemandeController@indexBrancardier');
Route::get('demandesMajor', 'API\DemandeController@indexMajor');
Route::get('demandesDemandeurs', 'API\DemandeController@indexDemandeurs');
Route::get('demandesDemandeurs', 'API\DemandeController@indexDemandeurs');
Route::post('accepterDemande', 'API\DemandeController@accepterDemande');
Route::post('terminer_AR_demande', 'API\DemandeController@terminer_AR_demande');
Route::post('terminerDemande', 'API\DemandeController@terminerDemande');
Route::post('probleme_demande', 'API\DemandeController@probleme_demande');
Route::post('annulerProblemeDemande', 'API\DemandeController@annulerProblemeDemande');
Route::post('annulerDemande', 'API\DemandeController@annulerDemande');
Route::get('MonService', 'API\ServiceController@MonService');
Route::put('service2/{id}', 'API\ServiceController@update2');


///Hajar Demandes
Route::get('declarerdemande', 'API\DeclarerDemandeController@index');
Route::post('senddemande', 'API\DeclarerDemandeController@infosDemande');

Route::get('serviceMajor', 'API\ServiceController@majorService');

Route::get('affecterdemandes', 'API\DemandeController@index1');
Route::post('sendidservicesource', 'API\DemandeController@branAffectation');
Route::post('sendbran', 'API\DemandeController@updateDemande');



///tawfiq Demandes
Route::get('demandes', 'API\DemandeController@index');

//pdf
Route::get('pdf/{id}', 'API\PdfController@show');
Route::get('pdfUrgence/{id}', 'API\PdfController@showUrgence');



Route::get('StatEtats', 'API\DemandeController@StatEtats');
Route::get('tauxDemandes', 'API\DemandeController@tauxDemandes');
Route::get('tauxCourses', 'API\DemandeController@tauxCourses');

Route::get('StatEtatsM', 'API\DemandeController@StatEtatsM');
Route::get('tauxDemandesM', 'API\DemandeController@tauxDemandesM');


Route::get('TempeAttentePatient', 'API\DemandeController@TempeAttentePatient');

Route::get('TempeAttentePatientM', 'API\DemandeController@TempeAttentePatientM');

Route::get('UrgenceId', 'API\ServiceController@UrgenceId');
Route::get('is', 'API\BrancardierController@is');