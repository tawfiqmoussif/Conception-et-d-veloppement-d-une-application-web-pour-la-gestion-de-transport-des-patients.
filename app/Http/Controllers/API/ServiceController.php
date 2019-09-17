<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index()
    {
        return DB::select('select DISTINCT services.id,
        services.intitule,
        services.nbr_bc,
        services.fixe ,
        services.urgence,
        hopitals.intitulé as hopital from services,hopitals
        where hopitals.id = services.hopital_id and services.deleted_at is NULL');
    }
    public function indexP() 
    {
        return DB::table('services')->select('services.id',
        'services.intitule',
        'services.nbr_bc',
        'services.fixe' ,
        'services.urgence',
        'hopitals.intitulé as hopital')
        ->join('hopitals','hopitals.id','=','services.hopital_id')
        ->whereNull('services.deleted_at')->paginate(3);
    }
    public function majorService() 
    {
        $maj=Auth::user()->id;
        return DB::select('select DISTINCT services.id,
        services.intitule
        from services,users
        where users.id = services.user_id and
        users.id='.$maj.' and
        services.deleted_at is NULL');
       

    }
    public function MonService() 
    {
        $maj=Auth::user()->id;
        return DB::select('select DISTINCT services.id,
        services.intitule,
        services.nbr_bc,
        services.fixe ,
        services.urgence,
        hopitals.intitulé as hopital,
        users.nom as major
        from services,users,hopitals
        where users.id = services.user_id and
        users.id='.$maj.' and
        hopitals.id = services.hopital_id and
        services.deleted_at is NULL');       
       

    }

 
    
public function search(){
    if ($search = \Request::get('q')) {
    $services =   DB::table('services')->select('services.id',
    'services.intitule',
    'services.nbr_bc',
    'services.fixe' ,
    'services.urgence',
    'hopitals.intitulé as hopital')
    ->join('hopitals','hopitals.id','=','services.hopital_id')
    ->where([
        ['services.intitule', 'LIKE', "%$search%"]
    
    ])
    ->orWhere([
        ['services.nbr_bc', 'LIKE', "%$search%"]
    ])->paginate(25);
    }else{
    $services = DB::table('services')->select('services.id',
    'services.intitule',
    'services.nbr_bc',
    'services.fixe' ,
    'services.urgence',
    'hopitals.intitulé as hopital')
    ->join('hopitals','hopitals.id','=','services.hopital_id')
    ->whereNull('services.deleted_at')->paginate(3);
    }
    return $services;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'intitule' =>  'required|string|max:191',
            'nbr_bc' =>  'required|integer|max:11',
            'fixe' =>  'required|integer|max:1',
            'urgence' =>  'required|integer|max:1',
            'hopital' =>  'required',
            'major' =>  'required',
            ]);
$id= DB::table('hopitals')->where('intitulé',$request['hopital'])->pluck('id');
$newService=new Service();
$newService->intitule=$request['intitule'];
$newService->nbr_bc=$request['nbr_bc'];
$newService->fixe=$request['fixe'];
$newService->urgence=$request['urgence'];
$newService->hopital_id=$id[0];
$newService->user_id=$request['major'];
$newService->save();

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
        $this->validate($request, [
            'intitule' =>  'required|string|max:191',
            'nbr_bc' =>  'required|integer|max:11',
            'fixe' =>  'required|integer|max:1',
            'urgence' =>  'required|integer|max:1',
            'hopital' =>  'required',
            'major' =>  'required',
            ]);  
        $serv =Service::findOrFail($id);
        $id= DB::table('hopitals')->where('intitulé',$request['hopital'])->pluck('id');
        $serv->intitule=$request['intitule'];
        $serv->nbr_bc=$request['nbr_bc'];
        $serv->fixe=$request['fixe'];
        $serv->urgence=$request['urgence'];
        $serv->hopital_id=$id[0];
        $newService->user_id=$request['major']; 
        $serv->save();
        
    }
    public function update2(Request $request, $id)
    {
        $this->validate($request, [
            'intitule' =>  'required|string|max:191',
            'nbr_bc' =>  'required|integer|max:11',
            'fixe' =>  'required|integer|max:1',
            'urgence' =>  'required|integer|max:1',
            'hopital' =>  'required',
            
            ]);  
        $serv =Service::findOrFail($id);
        $id= DB::table('hopitals')->where('intitulé',$request['hopital'])->pluck('id');
        $serv->intitule=$request['intitule'];
        $serv->nbr_bc=$request['nbr_bc'];
        $serv->fixe=$request['fixe'];
        $serv->urgence=$request['urgence'];
        $serv->hopital_id=$id[0];        
        $serv->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serv =Service::findOrFail($id);

        //delete bran
        $serv->delete();

        return ['message' => 'serv deleted !'];
    }
    public function indexAffectationNonFix()
    {
        return Service::where('fixe', 0)->paginate(3);
    }
    public function indexAffectationFix()
    {
        return Service::where('fixe', 1)->orderBy('intitule', 'asc')->get();
    }
    public function indexAffectationUrgence()
    {
        return Service::where('urgence',1)->orderBy('intitule', 'asc')->get();
    }
    public function isUrg(){
        $maj=Auth::user()->id;
        return DB::select('select DISTINCT services.id,
        services.intitule,
        services.urgence
        from services,users
        where users.id = services.user_id and
        users.id='.$maj.' and
        services.deleted_at is NULL');
       
    }


      public function UrgenceId(){
        return DB::select('select 
        services.id
        from services where services.urgence = 1 and
        services.deleted_at is NULL');
    }
}
