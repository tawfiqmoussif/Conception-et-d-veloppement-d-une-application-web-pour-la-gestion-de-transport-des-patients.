<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Service;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Carbon\CarbonImmutable;
use Carbon\Carbon;

class BrancardierController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
    return DB::table('users')->select('users.id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.password',
    'users.metier')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')
    ->where('user_role.role_id','!=', '6')->whereNull('users.deleted_at')->where('users.metier','!=', 'Sans')->paginate(3);
}

public function index2()
{
return DB::table('users')->select( 'users.id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password')
->join('user_role','users.id','=','user_role.user_id')
->join('roles','roles.id','=','user_role.role_id')
->where('user_role.role_id','=', '5')->whereNull('users.deleted_at')->where('users.metier','=', 'brancardier')->paginate(6);
}
public function brancardierMajor()
{
    $maj=Auth::user()->id;
   $id= DB::select('select DISTINCT services.id
        from services,users
        where users.id = services.user_id and
        users.id='.$maj.' and
        services.deleted_at is NULL');
return $result =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.id','=',$id[0]->id)->whereDate('service_user.date_fin', '=', Carbon::now())->paginate(1);
/* return DB::select("select DISTINCT users.id,
users.name,
users.nom,
users.prenom,
users.tel,
users.email,
users.photo,
users.cin,
users.age,
users.sexe,
users.metier,
users.ppr,   
users.poste_en_interne,
users.temporaire,
users.password from users 
join user_role on users.id = user_role.user_id 
join roles on roles.id = user_role.role_id where user_role.role_id = 5 and users.deleted_at is NULL and users.metier = 'brancardier'");*/
}

public function indexTemp()
{
return DB::table('users')->select( 'users.id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password')
->join('user_role','users.id','=','user_role.user_id')
->join('roles','roles.id','=','user_role.role_id')
->where('user_role.role_id','=', '5')->whereNull('users.deleted_at')->where('users.metier','=', 'brancardier')->where('users.temporaire','=', '1')->paginate(6);

}
public function index3()
{

    return DB::table('users')->select('users.id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.password',
    'users.metier')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')
    ->where('user_role.role_id','=', '6')->whereNull('users.deleted_at')->where('users.metier','=', 'Sans')->paginate(3);
}
public function index4($id)
{
$bran =User::findOrFail($id);
return $bran->profile;   
}
public function index5($id)
{
return User::findOrFail($id);

}
public function profileAuth()
{
return $user = Auth::user();

}
public function updateProfile($request, $id)
{
$bran =User::findOrFail($id);
$profil = $bran->profile;
$profil->update($request->all());   
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
if($request['photo']!='profile.png')

{ $name = time().'.' . explode('/', explode(':', substr($request['photo'], 0, strpos($request['photo'], ';')))[1])[1];

\Image::make($request['photo'])->save(public_path('img/profile/').$name);
$request->merge(['photo' => $name]);}

$this->validate($request, [
'name' =>  'required|string|max:191',
'email' =>  'required|string||email|max:191|unique:users',
'password' =>  'required|string|min:8',
'age' => 'required|integer|max:100|min:18',
'sexe' => 'required',
'ppr' => 'required',
'nom' => 'required',
'prenom' => 'required',
'tel' => 'required',
'poste_en_interne' => 'required',
]);

User::create([
'name' => $request['name'],
'email' => $request['email'],   
'password' => Hash::make($request['password']),
]);
$bran =User::where('email',$request['email'])->first();
$bran->age=$request['age'];
$bran->poste_en_interne=$request['poste_en_interne'];
$bran->temporaire=$request['temporaire'];
$bran->ppr=$request['ppr'];
$bran->sexe=$request['sexe'];
$bran->metier='brancardier';
$bran->nom=$request['nom'];
$bran->prenom=$request['prenom'];
$bran->tel=$request['tel'];
$bran->photo=$request['photo'];
$bran->save();
$bran->roles()->attach(Role::where('name','brancardier')->first());
}
public function storeUser(Request $request)
{         
$this->validate($request, [
'name' =>  'required|string|max:191',
'email' =>  'required|string||email|max:191|unique:users',
'password' =>  'required|string|min:8',
'metier' => 'required',
]);

User::create([
'name' => $request['name'],
'email' => $request['email'],   
'password' => Hash::make($request['password']),
]);
$user =User::where('email',$request['email'])->first();
$user->metier=$request['metier'];
$user->nom=$request['nom'];
$user->prenom=$request['prenom'];
$user->save();
if($request['metier']==='brancardier')
$user->roles()->attach(Role::where('name','brancardier')->first());
else if($request['metier']==='major')
$user->roles()->attach(Role::where('name','major')->first());
else if($request['metier']==='admin')
$user->roles()->attach(Role::where('name','admin')->first());
else if($request['metier']==='demandeur')
$user->roles()->attach(Role::where('name','demandeur')->first());
else if($request['metier']==='coordinateur')
$user->roles()->attach(Role::where('name','coordinateur')->first());
else
$user->roles()->attach(Role::where('name','not_active')->first());
}
public function updateUser2(Request $request,$id)
{       
$user =User::findOrFail($id);  
$this->validate($request, [
'name' =>  'required|string|max:191',
'email' =>  'required|string||email|max:191|unique:users,email,'.$user->id,
'password' =>  'required|string|min:8',
'metier' => 'required',
]);

$user->metier=$request['metier'];
$user->name=$request['name'];
$user->email=$request['email'];
$user->password=Hash::make($request['password']);
$user->save();
if($request['metier']==='brancardier')
$user->roles()->attach(Role::where('name','brancardier')->first());
else if($request['metier']==='major')
$user->roles()->attach(Role::where('name','major')->first());
else if($request['metier']==='admin')
$user->roles()->attach(Role::where('name','admin')->first());
else if($request['metier']==='demandeur')
$user->roles()->attach(Role::where('name','demandeur')->first());
else if($request['metier']==='coordinateur')
$user->roles()->attach(Role::where('name','coordinateur')->first());
else
$user->roles()->attach(Role::where('name','not_active')->first());
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function updateUser(Request $request, $id)
{
//return ['message' => 'update bran'];
$bran =User::findOrFail($id);
$currentPhoto = $bran->photo;
if($request['photo'] != $currentPhoto){
$name = time().'.' . explode('/', explode(':', substr($request['photo'], 0, strpos($request['photo'], ';')))[1])[1];
\Image::make($request['photo'])->save(public_path('img/profile/').$name);
$request->merge(['photo' => $name]);
$userPhoto = public_path('img/profile/').$currentPhoto;
if(file_exists($userPhoto)){
@unlink($userPhoto);
}
}
$this->validate($request, [
'name' =>  'required|string|max:191',
'email' =>  'required|string||email|max:191|unique:users,email,'.$bran->id,
'password' =>  'sometimes|min:8',
'age'=>'required',
'metier'=>'required',
]);     
$bran->name=$request['name'];
$bran->email=$request['email'];
$bran->password=Hash::make($request['password']);
$bran->age=$request['age'];
$bran->poste_en_interne=$request['poste_en_interne'];
$bran->temporaire=$request['temporaire'];
$bran->ppr=$request['ppr'];
$bran->sexe=$request['sexe'];
$bran->nom=$request['nom'];
$bran->prenom=$request['prenom'];
$bran->tel=$request['tel'];
$bran->photo=$request['photo'];
if($request['metier']!= $bran->metier)
{$bran->metier=$request['metier'];
$bran->roles()->attach(Role::where('name',$bran->metier)->first());}
else if($request['metier']==='Sans')
{
$bran->metier=$request['metier'];
$bran->roles()->attach(Role::where('name','not_active')->first());   
}
else{
$bran->metier=$request['metier'];
}
$bran->save();
// return ['message' => 'update bran'+$request['age']];
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
$bran =User::findOrFail($id);
//delete bran
$bran->delete();
return ['message' => 'bran deleted !'];
}
public function search(){
if ($search = \Request::get('q')) {
$users =   DB::table('users')->select( 'users.id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password')
->join('user_role','users.id','=','user_role.user_id')
->join('roles','roles.id','=','user_role.role_id')
->where([
    ['user_role.role_id', 'LIKE', '5'],
    ['users.metier', 'LIKE' ,'brancardier'],
    ['nom', 'LIKE', "%$search%"]

])
->orWhere([
    ['user_role.role_id', 'LIKE', '5'],
    ['users.metier', 'LIKE', 'brancardier'],
    ['prenom', 'LIKE', "%$search%"]
])
->orWhere([
    ['user_role.role_id', 'LIKE', '5'],
    ['users.metier', 'LIKE', 'brancardier'],
    ['email', 'LIKE', "%$search%"]
])->paginate(2);
}else{
$users = DB::table('users')->select( 'users.id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password')
->join('user_role','users.id','=','user_role.user_id')
->join('roles','roles.id','=','user_role.role_id')
->where('user_role.role_id','=', '5')->whereNull('users.deleted_at')->where('users.metier','=', 'brancardier')->paginate(6);
}
return $users;
}

public function selectedItem(Request $request){
$index =$request->index;
$users = DB::table('users')->select( 'users.id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password')
->join('user_role','users.id','=','user_role.user_id')
->join('roles','roles.id','=','user_role.role_id')
->where('user_role.role_id','=', '5')->whereNull('users.deleted_at')->where('users.metier','=', 'brancardier')->whereIn('users.id', $index)->get();
return $users;
}

public function search_v(){
    if ($search = \Request::get('q')) {
    $users_v =   DB::table('users')->select('users.id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.password',
    'users.metier')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')
    ->where([
        ['user_role.role_id', '!=', '6'],
        ['users.metier', 'LIKE' ,'Sans'],
        ['nom', 'LIKE', "%$search%"]
    
    ])
    ->orWhere([
        ['user_role.role_id', '!=', '6'],
        ['users.metier', '!=', 'Sans'],
        ['prenom', 'LIKE', "%$search%"]
    ])
    ->orWhere([
        ['user_role.role_id', '!=', '6'],
        ['users.metier', '!=', 'Sans'],
        ['email', 'LIKE', "%$search%"]
    ])->paginate(2);
    }else{
    $users_v =DB::table('users')->select('users.id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.password',
    'users.metier')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')
    ->where('user_role.role_id','!=', '6')->whereNull('users.deleted_at')->where('users.metier','!=', 'Sans')->paginate(3);
    }
    return $users_v;
    }



    
public function search_nv(){
    if ($search = \Request::get('q')) {
    $users_nv =   DB::table('users')->select('users.id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.password',
    'users.metier')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')
    ->where([
        ['user_role.role_id', 'LIKE', '6'],
        ['users.metier', 'LIKE' ,'Sans'],
        ['nom', 'LIKE', "%$search%"]
    
    ])
    ->orWhere([
        ['user_role.role_id', 'LIKE', '6'],
        ['users.metier', 'LIKE', 'Sans'],
        ['prenom', 'LIKE', "%$search%"]
    ])
    ->orWhere([
        ['user_role.role_id', 'LIKE', '6'],
        ['users.metier', 'LIKE', 'Sans'],
        ['email', 'LIKE', "%$search%"]
    ])->paginate(2);
    }else{
    $users_nv =DB::table('users')->select('users.id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.password',
    'users.metier')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')
    ->where('user_role.role_id','=', '6')->whereNull('users.deleted_at')->where('users.metier','=', 'Sans')->paginate(3);
    }
    return $users_nv;
    }

public function gestionAffecationsMan(Request $request){
$type =$request->etat_service;
if($type==="urgenceNormale"){
$date_debut=$request->date_debut;
$date_Fin=$request->date_Fin;
$id_services=$request->id_services;
$id_brancardiers=$request->id_brancardiers;

for($i=0;$i<sizeof($id_brancardiers);$i++){
$bran =User::findOrFail($id_brancardiers[$i]);
$bran->services()->attach($id_services,['date_debut'=>$date_debut,'date_fin' =>$date_Fin,'weekend' =>0]);   
}
}
elseif($type==="urgenceTemp"){
$date=$request->date;
$id_services=$request->id_services;
$id_brancardiers=$request->id_brancardiers;
$date_debut=$date." "."16:30";
$date_Fin=$date." "."18:00";
for($i=0;$i<sizeof($id_brancardiers);$i++){
$bran =User::findOrFail($id_brancardiers[$i]);
$bran->services()->attach($id_services,['date_debut'=>$date_debut,'date_fin' =>$date_Fin,'weekend' =>0]);   
}
return ['message'=>$date];

}
elseif($type==="nonFix"){
$id_services=$request->id_services;
$id_brancardiers=$request->id_brancardiers;
$id_brancardiers=$request->id_brancardiers;
$date=$request->date;
$date_debut=$date.' '.'08:00';
$date_Fin=$date.' '.'16:30';
for($i=0;$i<sizeof($id_brancardiers);$i++){
for($j=0;$j<sizeof($id_services);$j++){
$bran =User::findOrFail($id_brancardiers[$i]);
$bran->services()->attach($id_services[$j],['date_debut'=>$date_debut,'date_fin' =>$date_Fin,'weekend' =>0]);
}
}
return ['message'=>sizeof($id_brancardiers)];

}
elseif($type==="fix"){
$id_services=$request->id_services;
$id_brancardiers=$request->id_brancardiers;
$id_brancardiers=$request->id_brancardiers;
$date=$request->date;
$date_debut=$date.' '.'08:00';
$date_Fin=$date.' '.'16:30';
for($i=0;$i<sizeof($id_brancardiers);$i++){
$bran =User::findOrFail($id_brancardiers[$i]);
$bran->services()->attach($id_services,['date_debut'=>$date_debut,'date_fin' =>$date_Fin,'weekend' =>0]);   
}
return ['message'=>sizeof($id_brancardiers)];

}

// return ['message'=>$type];
}
public function UpdateAffectation(Request $request){
DB::update('update service_user set user_id=? where user_id = ? and date_debut = ? and date_fin =? and service_id = ? ',[$request['id_newBrancardier'],$request['id_oldBrancardier'],$request['date_debut'],$request['date_fin'],$request['id_service']]);
return ['message'=>$request['id_service']];
}
public function subSemaine($n){
$dateNow7=Carbon::now()->startOfWeek()->subDays(8*$n);
$result =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->whereDate('service_user.date_Fin', '<=', Carbon::now()->startOfWeek()->subDays(3+(($n-1)*6)))->whereDate('service_user.date_debut', '>',$dateNow7)->get();
}
public function affectationNonUrgenceBackWeek($id,$n,$n2){
$vendredi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(3+(7*($n-1))))->get();
$jeudi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(4+(7*($n-1))))->get(); 
$mercredi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(5+(7*($n-1))))->get(); 
$mardi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(6+(7*($n-1))))->get();
$lundi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7+(7*($n-1))))->get(); 

return ['lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'date_debut'=>Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*$n),'date_fin'=>Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays((7*$n)-4)];
}
public function affectationNonUrgenceNextWeek($id,$n,$n2){
$vendredi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut', 
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(4+(7*($n))))->get();
$jeudi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n))))->get(); 
$mercredi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(2+(7*($n))))->get(); 
$mardi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(1+(7*($n))))->get();
$lundi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays((7*($n))))->get(); 

return ['lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'date_debut'=>Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7*$n),'date_fin'=>Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(4+(7*($n)))];
}
public function affectationNonUrgence($id){
$dateNow7=Carbon::now()->startOfWeek()->add(5, 'day');

$result =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_debut', '>=', Carbon::now()->startOfWeek())->whereDate('service_user.date_Fin', '<',$dateNow7)->get();

$vendredi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(4))->get();
$jeudi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(3))->get(); 
$mercredi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(2))->get(); 
$mardi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(1))->get();
$lundi =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek())->get(); 

return ['lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'date_debut'=>Carbon::now()->startOfWeek(),'date_fin'=>Carbon::now()->startOfWeek()->addDays(4)];  




}

public function affectationBrancardierBackWeek($n,$n2){
    $id_bran=Auth::user()->id;
$dimanche =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(1+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(1+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$samedi =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(2+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(2+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$vendredi =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(3+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(3+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$jeudi =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(4+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(4+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
$mercredi =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(5+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(5+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
$mardi =DB::table('users')->select( 
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(6+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(6+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$lundi =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(7+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 

/////Groupe de soir

$dimanche1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*($n-1)))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(1+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$samedi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(1+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(2+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$vendredi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(2+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(3+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$jeudi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(3+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(4+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
$mercredi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(4+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(5+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
$mardi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(5+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(6+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$lundi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(6+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(7+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();

/// Exception
$lundi2=DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*($n-1))->subDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(1+(7*($n-1)))->subDays(7)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();


/////Temp

$vendrediTemp =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->addDays(7*($n2-1))->startOfHour()->subDays(3+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$jeudiTemp =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(4+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
$mercrediTemp =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(5+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
$mardiTemp =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(6+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
$lundiTemp =DB::table('users')->select( 
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(7+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 

return ['lundi' =>$lundi,'lundi2' =>$lundi2,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp,'samedi'=>$samedi,'dimanche'=>$dimanche,'samedi1'=>$samedi1,'dimanche1'=>$dimanche1,'date_debut'=>Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*$n),'date_fin'=>Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays((7*($n-1)))];
}


public function affectationUrgenceBackWeek($id,$n,$n2){

    $dimanche =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(1+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(1+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $samedi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(2+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(2+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $vendredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(3+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(3+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(4+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(4+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(5+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(5+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(6+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(6+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(7+(7*($n-1)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    
    /////Groupe de soir
    
    $dimanche1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*($n-1)))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(1+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $samedi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(1+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(2+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $vendredi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(2+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(3+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(3+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(4+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercredi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(4+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(5+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(5+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(6+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(6+(7*($n-1))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(7+(7*($n-1)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    
    /// Exception
    $lundi2=DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*($n-1))->subDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(1+(7*($n-1)))->subDays(7)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    
    
    /////Temp
    
    $vendrediTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->addDays(7*($n2-1))->startOfHour()->subDays(3+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(4+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercrediTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(5+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(6+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(7*($n2-1))->subDays(7+(7*($n-1)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    
    return ['lundi' =>$lundi,'lundi2' =>$lundi2,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp,'samedi'=>$samedi,'dimanche'=>$dimanche,'samedi1'=>$samedi1,'dimanche1'=>$dimanche1,'date_debut'=>Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays(7*$n),'date_fin'=>Carbon::now()->startOfWeek()->addDays(7*($n2-1))->subDays((7*($n-1)))];
    }

public function affectationUrgenceNextWeek($id,$n,$n2){

    $dimanche =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(6+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(6+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $samedi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(5+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(5+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $vendredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(4+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(4+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(3+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(2+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(2+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(1+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(1+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays((7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays((7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    
    /////Groupe de soir
    
    $dimanche1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(6+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $samedi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(6+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(5+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $vendredi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(5+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(4+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(4+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(3+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercredi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(2+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(2+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(1+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundi1 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(1+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays((7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    
    //////Exception
    $lundi2 =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->subDays(7)->addDays(7+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(6+(7*($n)))->subDays(7)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    
    /////Temp
    
    $vendrediTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->subDays(7*($n2-1))->startOfHour()->addDays(4+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercrediTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(2+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(1+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays((7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    
    return ['lundi' =>$lundi,'lundi2' =>$lundi2,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp,'samedi'=>$samedi,'dimanche'=>$dimanche,'samedi1'=>$samedi1,'dimanche1'=>$dimanche1,'date_debut'=>Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7*$n),'date_fin'=>Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7*($n+1))];
    }

    public function affectationBrancardierNextWeek($n,$n2){
        $id_bran=Auth::user()->id;
        $dimanche =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(6+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(6+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $samedi =DB::table('users')->select( 
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(5+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(5+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $vendredi =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(4+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(4+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $jeudi =DB::table('users')->select( 
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(3+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $mercredi =DB::table('users')->select( 
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(2+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(2+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $mardi =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(1+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(1+(7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lundi =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays((7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays((7*($n)))->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        
        /////Groupe de soir
        
        $dimanche1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(6+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $samedi1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(6+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(5+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $vendredi1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(5+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(4+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $jeudi1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(4+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(3+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $mercredi1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(2+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $mardi1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(2+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(1+(7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lundi1 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(1+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays((7*($n)))->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        
        //////Exception
        $lundi2 =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7*($n2-1))->subDays(7)->addDays(7+(7*($n))))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(6+(7*($n)))->subDays(7)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        
        /////Temp
        
        $vendrediTemp =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->subDays(7*($n2-1))->startOfHour()->addDays(4+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $jeudiTemp =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(3+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $mercrediTemp =DB::table('users')->select( 
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(2+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $mardiTemp =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays(1+(7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lundiTemp =DB::table('users')->select(
        'services.id',
        'services.fixe',
        'services.urgence',
        'services.hopital_id',
        'services.intitule',
        'service_user.date_debut',
        'service_user.date_fin',
        'service_user.weekend'
        )
        ->join('service_user','service_user.user_id','=','users.id')
        ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7*($n2-1))->addDays((7*($n)))->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        
        return ['lundi' =>$lundi,'lundi2' =>$lundi2,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp,'samedi'=>$samedi,'dimanche'=>$dimanche,'samedi1'=>$samedi1,'dimanche1'=>$dimanche1,'date_debut'=>Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7*$n),'date_fin'=>Carbon::now()->startOfWeek()->subDays(7*($n2-1))->addDays(7*($n+1))];
        }
public function affectationUrgence($id){
    $dimanche =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(6))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(6)->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $samedi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',  
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(5))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(5)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $vendredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(4))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(4)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(3))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(3)->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(2))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(2)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(1))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(1)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 



/////Exception

$lundi2 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7)->addDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(6)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();


    
/////Group de soir

$dimanche1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(6)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$samedi1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(6))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(5)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$vendredi1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(5))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(4)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$jeudi1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(3)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
$mercredi1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(2)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
$mardi1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(1)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$lundi1 =DB::table('users')->select( 'service_user.user_id',
'users.name',
'users.nom',
'users.prenom',
'users.tel',
'users.email',
'users.photo',
'users.cin',
'users.age',
'users.sexe',
'users.metier',
'users.ppr',   
'users.poste_en_interne',
'users.temporaire',
'users.password',
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(1))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 


    

    ////Temp
    $vendrediTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(4)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    $jeudiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(3)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
    $mercrediTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(2)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
    $mardiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(1)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    $lundiTemp =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    return ['lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'lundi2' =>$lundi2,'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp,'samedi'=>$samedi,'dimanche'=>$dimanche,'samedi1'=>$samedi1,'dimanche1'=>$dimanche1,'date_debut'=>Carbon::now()->startOfWeek(),'date_fin'=>Carbon::now()->startOfWeek()->addDays(6)];
}


public function affectationBrancardier(){
    $id_bran=Auth::user()->id;
    $dimanche =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(6))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(6)->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $samedi =DB::table('users')->select( 
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(5))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(5)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $vendredi =DB::table('users')->select( 
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(4))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(4)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $jeudi =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(3))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(3)->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mercredi =DB::table('users')->select( 'service_user.user_id',
    'users.name',
    'users.nom',
    'users.prenom',
    'users.tel',
    'users.email',
    'users.photo',
    'users.cin',
    'users.age',
    'users.sexe',
    'users.metier',
    'users.ppr',   
    'users.poste_en_interne',
    'users.temporaire',
    'users.password',
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(2))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(2)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
    $mardi =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(1))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(1)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
    $lundi =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 



/////Exception

$lundi2 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7)->addDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(6)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();


    
/////Group de soir

$dimanche1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(6)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$samedi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(6))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(5)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$vendredi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(5))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(4)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$jeudi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(3)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
$mercredi1 =DB::table('users')->select( 
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(2)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
$mardi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->addDays(1)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
$lundi1 =DB::table('users')->select(
'services.id',
'services.fixe',
'services.urgence',
'services.hopital_id',
'services.intitule',
'service_user.date_debut',
'service_user.date_fin',
'service_user.weekend'
)
->join('service_user','service_user.user_id','=','users.id')
->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->addDays(1))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 


    

    ////Temp
    $vendrediTemp =DB::table('users')->select( 
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(4)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    $jeudiTemp =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(3)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
    $mercrediTemp =DB::table('users')->select( 
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(2)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
    $mardiTemp =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->addDays(1)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    $lundiTemp =DB::table('users')->select(
    'services.id',
    'services.fixe',
    'services.urgence',
    'services.hopital_id',
    'services.intitule',
    'service_user.date_debut',
    'service_user.date_fin',
    'service_user.weekend'
    )
    ->join('service_user','service_user.user_id','=','users.id')
    ->join('services','services.id','=','service_user.service_id')->where('service_user.user_id','=',$id_bran)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    return ['lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'lundi2' =>$lundi2,'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp,'samedi'=>$samedi,'dimanche'=>$dimanche,'samedi1'=>$samedi1,'dimanche1'=>$dimanche1,'date_debut'=>Carbon::now()->startOfWeek(),'date_fin'=>Carbon::now()->startOfWeek()->addDays(6)];
}

public function Carbon(){
return ['message'=>Carbon::now()->startOfWeek()->startOfHour()->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss')];
}
public function is(){
    $me=Auth::user()->id;
    return DB::table('users')->select('user_role.role_id as me')
    ->join('user_role','users.id','=','user_role.user_id')
    ->join('roles','roles.id','=','user_role.role_id')->whereNull('users.deleted_at')->where('users.id','=', $me)->get();
}
}