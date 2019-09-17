<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use DB;

class CoordinateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
        public function index()
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
->where('user_role.role_id','=', '2')->whereNull('users.deleted_at')->where('users.metier','=', 'coordinateur')->paginate(1);
    
    }

    public function search(){
        if ($search = \Request::get('q')) {
        $coordinateurs =   DB::table('users')->select( 'users.id',
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
            ['user_role.role_id', 'LIKE', '2'],
            ['users.metier', 'LIKE' ,'coordinateur'],
            ['nom', 'LIKE', "%$search%"]
        
        ])
        ->orWhere([
            ['user_role.role_id', 'LIKE', '2'],
            ['users.metier', 'LIKE', 'coordinateur'],
            ['prenom', 'LIKE', "%$search%"]
        ])
        ->orWhere([
            ['user_role.role_id', 'LIKE', '2'],
            ['users.metier', 'LIKE', 'coordinateur'],
            ['email', 'LIKE', "%$search%"]
        ])->paginate(25);
        }else{
        $coordinateurs = DB::table('users')->select( 'users.id',
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
        ->where('user_role.role_id','=', '3')->whereNull('users.deleted_at')->where('users.metier','=', 'coordinateur')->paginate(1);
        }
        return $coordinateurs;
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

        $maj =User::where('email',$request['email'])->first();
        $maj->age=$request['age'];
        $maj->poste_en_interne=$request['poste_en_interne'];
        $maj->ppr=$request['ppr'];
        $maj->sexe=$request['sexe'];
        $maj->metier='coordinateur';
        $maj->nom=$request['nom'];
        $maj->prenom=$request['prenom'];
        $maj->tel=$request['tel'];
        $maj->photo=$request['photo'];
        $maj->save();
        $maj->roles()->attach(Role::where('name','coordinateur')->first());
      
        
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
    public function update(Request $request, $id)
    {
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

           //
        //return ['message' => 'update maj'];
    $this->validate($request, [
        'name' =>  'required|string|max:191',
        'email' =>  'required|string||email|max:191|unique:users,email,'.$bran->id,
        'password' =>  'sometimes|min:8',
        'age'=>'required'
        ]);
        $bran->name=$request['name'];
        $bran->email=$request['email'];
        $bran->password=Hash::make($request['password']);
        $bran->age=$request['age'];
        $bran->poste_en_interne=$request['poste_en_interne'];
        $bran->ppr=$request['ppr'];
        $bran->sexe=$request['sexe'];
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
       
        $bran->nom=$request['nom'];
        $bran->prenom=$request['prenom'];
        $bran->tel=$request['tel'];
        $bran->photo=$request['photo'];
        $bran->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $coor =User::findOrFail($id);

        //delete bran
        $coor->delete();

        return ['message' => 'coor deleted !'];
    }
}
