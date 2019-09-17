<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use App\Hospitaisation;
use App\Patient;
use App\Etat;
use App\Demande;
use Auth;
use App\Role;
use App\Notifications\DemandeNotification;
use Illuminate\Support\Facades\Notification;
use App\User;

class DeclarerDemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return DB::select('select patients.id,patients.nom 
        from patients,hospitalisations
        where hospitalisations.patient_id = patients.id');
    }


    public function infosDemande(Request $request){

    

        $id_hospitalier=$request['id_hospitalier'];
        $id_service_source=$request['id_service_source'];
        $id_service_destination=$request['id_service_destination'];
        $accomp=$request['accomp'];
        $doss=$request['doss'];
        $bill=$request['bill'];



        $newDemande = new Demande();
        $newDemande->accompagnant=$accomp;
        $newDemande->dossier_medical=$doss;
        $newDemande->billet_rose=$bill;
        $newDemande->user_id_demandeur=Auth::user()->id;
        $newDemande->user_id_brancardier=null;
        $newDemande->id_service_source=$id_service_source;
        $newDemande->id_service_destination=$id_service_destination;
        $newDemande->hospitalisation_id=$id_hospitalier;
        $newDemande->save();
        $newDemande->etats()->attach(Etat::where('libelle','En attente')->first());
         $brancardiers=User::all()->filter(function($user){
             return $user->hasRole('brancardier');//were id service = service source 
         });
        $brancardiers=User::find(2)->get();
        Notification::send($brancardiers,new DemandeNotification(Demande::latest('id')->first()));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
