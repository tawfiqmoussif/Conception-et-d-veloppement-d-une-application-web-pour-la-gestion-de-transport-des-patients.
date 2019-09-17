<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Demande;
use App\Etat;
use App\Patient;
use App\Lit;
use Auth;
use App\Hospitalisation;
use Illuminate\Support\Arr;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        $demandes= Demande::all();
        $len=Demande::count();
        $myArray = array();
        foreach ($demandes as $demande) 
        {
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }





    public function indexBrancardier()
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        
        
        
        $bran=Auth::user();
        $now=Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $service_bran=DB::select("select service_user.service_id,service_user.date_debut,service_user.date_fin from service_user where service_user.user_id = ".$bran->id);
        $demandes= Demande::all();
        $len=0;
        $myArray = array();
        foreach ($demandes as $demande) 
        {
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          for($i=0;$i<sizeof($service_bran);$i++)
         {
          if($demande->id_service_source===$service_bran[$i]->service_id && $demande->created_at>=$service_bran[$i]->date_debut && $demande->created_at<= $service_bran[$i]->date_fin){
            if($etat->libelle==='En attente'){
              $len+=1;
            }
            else{
              if($demande->user_id_brancardier===$bran->id){
                $len+=1;
              }
            }
           }
         }
        }
        foreach ($demandes as $demande) 
        {
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          $_serviceSource = Demande::find($demande->id)->service_source()->first();
          for($i=0;$i<sizeof($service_bran);$i++)
         {
          if($demande->id_service_source===$service_bran[$i]->service_id && $demande->created_at>=$service_bran[$i]->date_debut && $demande->created_at<= $service_bran[$i]->date_fin){
            if($etat->libelle==='En attente'){
              $brancardier = Demande::find($demande->id)->brancardier()->get();
              $demandeur = Demande::find($demande->id)->demandeur()->get();
              $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
              $patient =Patient::findOrFail($hospitalisation->patient_id);
              $lit =Lit::findOrFail($hospitalisation->lit_id);
              $serviceDestination = Demande::find($demande->id)->service_destination()->get();
              $serviceSource = Demande::find($demande->id)->service_source()->get();
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
              $created_at_demande=$demande->created_at;
              Carbon::setLocale('fr');
              $diff=Carbon::parse($created_at_demande)-> diffForHumans();
              
              $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
            } 
            else{
              if($demande->user_id_brancardier===$bran->id){
                $brancardier = Demande::find($demande->id)->brancardier()->get();
                $demandeur = Demande::find($demande->id)->demandeur()->get();
                $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
                $patient =Patient::findOrFail($hospitalisation->patient_id);
                $lit =Lit::findOrFail($hospitalisation->lit_id);
                $serviceDestination = Demande::find($demande->id)->service_destination()->get();
                $serviceSource = Demande::find($demande->id)->service_source()->get();
                $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
                $created_at_demande=$demande->created_at;
                Carbon::setLocale('fr');
                $diff=Carbon::parse($created_at_demande)-> diffForHumans();
                
                $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
              }
            }
           }
         }
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }
    public function indexMajor()
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        
        
        
        $maj=Auth::user();
        $service_dest=DB::select('select services.id from services where services.user_id ='.$maj->id);
        $demandes= Demande::all();
        $len=0;
        $is_demandeur=0;
        $is_dest=0;
        $myArray = array();
        foreach ($demandes as $demande) 
        {
          if($maj->id==$demande->user_id_demandeur || $demande->id_service_destination==$service_dest[0]->id){
            $len+=1;
           }
         
        }
        foreach ($demandes as $demande) 
        {   
          if($maj->id===$demande->user_id_demandeur || $demande->id_service_destination===$service_dest[0]->id){
            if($demande->id_service_destination===$service_dest[0]->id) {$is_dest=1;} else if($maj->id===$demande->user_id_demandeur ) {$is_demandeur=1;}
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len,'is_dest'=>$is_dest,'is_demandeur'=>$is_demandeur);
           }
         
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }

    public function indexDemandeurs()
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        
        
        
        $dem=Auth::user();
        $demandes= Demande::all();
        $len=0;
        $myArray = array();
        foreach ($demandes as $demande) 
        {
          if($dem->id==$demande->user_id_demandeur){
            $len+=1;
           }
         
        }
        foreach ($demandes as $demande) 
        {   
          if($dem->id===$demande->user_id_demandeur){
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
           }
         
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }





    public function filtreEtatBrancardier($id)
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        
        
        
        $bran=Auth::user();
        $now=Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $service_bran=DB::select("select service_user.service_id,service_user.date_debut,service_user.date_fin from service_user where service_user.user_id = ".$bran->id);
        $demandes= Demande::all();
        $len=0;
        $myArray = array();
        foreach ($demandes as $demande) 
        {
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
      
          for($i=0;$i<sizeof($service_bran);$i++)
         {
          if(($demande->id_service_source===$service_bran[$i]->service_id && $demande->created_at>=$service_bran[$i]->date_debut && $demande->created_at<= $service_bran[$i]->date_fin)&&($etat->id==$id)){
            if($etat->libelle==='En attente'){
              $len+=1;
            }
            else{
              if($demande->user_id_brancardier===$bran->id){
                $len+=1;
              }
            }
           }
         }
        }
        foreach ($demandes as $demande) 
        {
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          $_serviceSource = Demande::find($demande->id)->service_source()->first();
          for($i=0;$i<sizeof($service_bran);$i++)
         {
          if(($demande->id_service_source===$service_bran[$i]->service_id && $demande->created_at>=$service_bran[$i]->date_debut && $demande->created_at<= $service_bran[$i]->date_fin)&&($etat->id==$id)){
            if($etat->libelle==='En attente'){
              $brancardier = Demande::find($demande->id)->brancardier()->get();
              $demandeur = Demande::find($demande->id)->demandeur()->get();
              $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
              $patient =Patient::findOrFail($hospitalisation->patient_id);
              $lit =Lit::findOrFail($hospitalisation->lit_id);
              $serviceDestination = Demande::find($demande->id)->service_destination()->get();
              $serviceSource = Demande::find($demande->id)->service_source()->get();
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
              $created_at_demande=$demande->created_at;
              Carbon::setLocale('fr');
              $diff=Carbon::parse($created_at_demande)-> diffForHumans();
              
              $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
            } 
            else{
              if($demande->user_id_brancardier===$bran->id){
                $brancardier = Demande::find($demande->id)->brancardier()->get();
                $demandeur = Demande::find($demande->id)->demandeur()->get();
                $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
                $patient =Patient::findOrFail($hospitalisation->patient_id);
                $lit =Lit::findOrFail($hospitalisation->lit_id);
                $serviceDestination = Demande::find($demande->id)->service_destination()->get();
                $serviceSource = Demande::find($demande->id)->service_source()->get();
                $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
                $created_at_demande=$demande->created_at;
                Carbon::setLocale('fr');
                $diff=Carbon::parse($created_at_demande)-> diffForHumans();
                
                $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
              }
            }
           }
         }
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }
    public function filtreEtatDemandeurs($id)
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        
        
        
        $dem=Auth::user();
        $demandes= Demande::all();
        $len=0;
        
        $myArray = array();
        foreach ($demandes as $demande) 
        {
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          if($dem->id==$demande->user_id_demandeur && $etat->id==$id){
            $len+=1;
           }
         
        }
        foreach ($demandes as $demande) 
        {   
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          if($dem->id==$demande->user_id_demandeur && $etat->id==$id){
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
           }
         
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }

    public function filtreEtatMajor($id)
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        
        
        
        $maj=Auth::user();
        $service_dest=DB::select('select services.id from services where services.user_id ='.$maj->id);
        $demandes= Demande::all();
        $is_demandeur=0;
        $is_dest=0;
        $len=0;
        
        $myArray = array();
        foreach ($demandes as $demande) 
        {
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          if(($maj->id==$demande->user_id_demandeur || $demande->id_service_destination==$service_dest[0]->id) && ($etat->id==$id)){
            $len+=1;
           }
         
        }
        foreach ($demandes as $demande) 
        {   
          $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          if(($maj->id==$demande->user_id_demandeur || $demande->id_service_destination==$service_dest[0]->id)&& ($etat->id==$id)){
            if($demande->id_service_destination===$service_dest[0]->id) {$is_dest=1;} else if($maj->id===$demande->user_id_demandeur ) {$is_demandeur=1;}
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len,'is_dest'=>$is_dest,'is_demandeur'=>$is_demandeur);
           }
         
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }
    public function filtreEtat($id)
    {
      //  $demandes=Demande::orderby('id','desc')->paginate(25);
       // $brancardier = $demandes->brancardier();
      //  $brancardier = Demande::brancardier()->name;
        //$brancardier = Demande::with('brancardier') ->whereNotNull('user_id_brancardier')->first();
        $demandes= Demande::all();
        $myArray = array();
        $len=0;
        foreach ($demandes as $demande) 
        {
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          if($etat->id==$id){
           $len+=1;
          }
        }
        foreach ($demandes as $demande) 
        {
            $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
          if($etat->id==$id){
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();        
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff,'len'=>$len);
          }
        }
       
        if($len!=0) return   json_encode($myArray); else return 0;
    }



    

    public function accepterDemande(Request $request){
      $demande=Demande::findOrFail($request['id_demande']);
      $demande->user_id_brancardier=Auth::user()->id;
      $demande->save();
      $demande->etats()->attach(Etat::where('libelle','En traitement')->first());
    }

    public function terminer_AR_demande(Request $request){
      $demande=Demande::findOrFail($request['id_demande']);
      $demande->etats()->attach(Etat::where('libelle','Terminée Avec réserve')->first());
    }
    public function terminerDemande(Request $request){
      $demande=Demande::findOrFail($request['id_demande']);
      $demande->etats()->attach(Etat::where('libelle','Terminée')->first());
    }
    public function probleme_demande(Request $request){
      $demande=Demande::findOrFail($request['id_demande']);
      $demande->etats()->attach(Etat::where('libelle','Problème')->first());
    }
    
    public function annulerProblemeDemande(Request $request){
      $demande=Demande::findOrFail($request['id_demande']);
      $demande->etats()->attach(Etat::where('libelle','En traitement')->first());
    }


    public function annulerDemande(Request $request){
      $demande=Demande::findOrFail($request['id_demande']);
      $demande->etats()->detach(Etat::where('libelle','En attente')->first());
      $demande->delete();
      
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






    ///////Hajar

    public function index1()
    {
     
        $demandes= Demande::all();
        $myArray = array();
        foreach ($demandes as $demande) 
        {
            $brancardier = Demande::find($demande->id)->brancardier()->get();
            $demandeur = Demande::find($demande->id)->demandeur()->get();
            $hospitalisation = Demande::find($demande->id)->hospitalisation()->first();
            $patient =Patient::findOrFail($hospitalisation->patient_id);
            $lit =Lit::findOrFail($hospitalisation->lit_id);
            $serviceDestination = Demande::find($demande->id)->service_destination()->get();
            $serviceSource = Demande::find($demande->id)->service_source()->get();
            $etat = Demande::find($demande->id)->etats()->orderBy('etats.id', 'desc')->first();            
            $created_at_demande=$demande->created_at;
            Carbon::setLocale('fr');
            $diff=Carbon::parse($created_at_demande)-> diffForHumans();
            
            $myArray []= array('hospitalisation'=>$hospitalisation,'demandeur'=>$demandeur,'brancardier'=>$brancardier,'serviceSource'=>$serviceSource,'serviceDestination'=>$serviceDestination,'etat'=>$etat,'demande'=>$demande,'Patient'=>$patient,'lit'=>$lit,'diff'=>$diff);
        }
        
        
       
        return   json_encode($myArray);
    }
    
  public function branAffectation(Request $request){
        $id_service_source=$request['id_service_source'];
        $idS=(int)$id_service_source;
        $created_at=$request['created_at'];          
        $id_bran1=array();

    
                    $id_bran=DB::select("select DISTINCT users.id,
                    users.nom,
                    users.prenom  
                    from service_user,users 
                    where service_user.user_id=users.id and service_user.service_id = ".$idS." and '".$created_at."' BETWEEN service_user.date_debut and service_user.date_fin");
      //." and '".$created_at."' BETWEEN service_user.date_debut and service_user.date_fin"
                       
                        $id_bran_aff=DB::select("select DISTINCT demandes.user_id_brancardier
                            from demandes,etat_demande,etats
                            where etats.libelle = 'En traitement' 
                            and etat_demande.demande_id=demandes.id 
                            and etat_demande.etat_id=etats.id ");
                    
                        
                        if($id_bran_aff){
                                             
                                $id_bran1=DB::select("select  DISTINCT users.id,
                                users.nom,
                                users.prenom 
                                from users,service_user
                                where service_user.user_id=users.id and service_user.user_id not in 
                                (select DISTINCT demandes.user_id_brancardier
                                from demandes,etat_demande,etats
                                where etats.libelle = 'En traitement' 
                                and etat_demande.demande_id=demandes.id 
                                and etat_demande.etat_id=etats.id )
                                 and service_user.service_id = ".$idS." and '".$created_at."' BETWEEN service_user.date_debut and service_user.date_fin ");  
                               //." and '".$created_at."' BETWEEN service_user.date_debut and service_user.date_fin ")               
                                   if($id_bran1){
                                    return $id_bran1; 
                                     }
                                     else{
                                         return 0;
                                     }
                                }
                        else{
                            
                            if($id_bran){
                                return $id_bran; 
                                 }
                                 else{
                                     return 0;
                                 }
                        }
                    
                     
                
        }
       
        public function StatEtats(){
          $demandes= Demande::all();
          $myArray = array();
          $count1=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="En attente"){
             $count1+=1;
            }
          }
          $count2=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="Problème"){
             $count2+=1;
            }
          }
          $count3=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="En traitement"){
             $count3+=1;
            }
          }
          $count4=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="Terminée Avec réserve"){
             $count4+=1;
            }
          }
          $count5=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="Terminée"){
             $count5+=1;
            }
          }
                        $sum=$count1+$count2+$count3+$count4+$count5;
                        $enAttente=0;
                        $enTraitemment=0;
                        $probleme=0;
                        $terminee=0;
                        $termineeReserve=0;
                     if($sum!=0){
                      $enAttente=($count1/$sum)*100;
                      $enTraitemment=($count3/$sum)*100;
                      $probleme=($count2/$sum)*100;
                      $terminee=($count5/$sum)*100;
                      $termineeReserve=($count4/$sum)*100;
                     }
             return ["enAttente"=>$enAttente,"enTraitemment"=>$enTraitemment,"probleme"=>$probleme,"terminee"=>$terminee,"termineeReserve"=>$termineeReserve ];
        }
    
    
        public function StatEtatsM(){
          $maj=Auth::user()->id;
          $serv=DB::select('select DISTINCT services.id as id ,
          services.intitule
          from services,users
          where users.id = services.user_id and
          users.id='.$maj.' and
          services.deleted_at is NULL');
    
          $demandes= Demande::where('id_service_source','=',$serv[0]->id)->get();
          $myArray = array();
          $count1=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="En attente"){
             $count1+=1;
            }
          }
          $count2=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="Problème"){
             $count2+=1;
            }
          }
          $count3=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="En traitement"){
             $count3+=1;
            }
          }
          $count4=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="Terminée Avec réserve"){
             $count4+=1;
            }
          }
          $count5=0;
          foreach ($demandes as $demande) 
          {
              $etat = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'desc')->first();
            if($etat->libelle=="Terminée"){
             $count5+=1;
            }
          }
                        $sum=$count1+$count2+$count3+$count4+$count5;
                        $enAttente=0;
                        $enTraitemment=0;
                        $probleme=0;
                        $terminee=0;
                        $termineeReserve=0;
                        if($sum!=0){
                     $enAttente=($count1/$sum)*100;
                     $enTraitemment=($count3/$sum)*100;
                     $probleme=($count2/$sum)*100;
                     $terminee=($count5/$sum)*100;
                     $termineeReserve=($count4/$sum)*100;
                        }
             return ["enAttente"=>$enAttente,"enTraitemment"=>$enTraitemment,"probleme"=>$probleme,"terminee"=>$terminee,"termineeReserve"=>$termineeReserve ];
        }
    
    
    
    
    
    
    
    
    
     public function tauxDemandes(){
          $vendredi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->count();
          $jeudi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->count();
          $mercredi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->count();
          $mardi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->count();
          $lundi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek())->count();
    
    
          $dimanche1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(6))->count();
          $samedi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(5))->count();
          $vendredi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->count();
          $jeudi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->count();
          $mercredi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->count();
          $mardi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->count();
          $lundi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek())->count();
          return ["vendredi0"=>$vendredi0,"jeudi0"=>$jeudi0,"mercredi0"=>$mercredi0,"mardi0"=>$mardi0,"lundi0"=>$lundi0,"vendredi1"=>$vendredi1,"jeudi1"=>$jeudi1,"mercredi1"=>$mercredi1,"mardi1"=>$mardi1,"lundi1"=>$lundi1,"samedi1"=>$samedi1,"dimanche1"=>$dimanche1];
        }
    
        public function tauxDemandesM(){
           $maj=Auth::user()->id;
          $serv=DB::select('select DISTINCT services.id as id ,
          services.intitule,
          services.urgence as urgence
          from services,users
          where users.id = services.user_id and
          users.id='.$maj.' and
          services.deleted_at is NULL');
    
         if($serv[0]->urgence===0){
          $demandes= Demande::where('id_service_source','=',$serv[0]->id)->get();
          $vendredi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->where('id_service_source','=',$serv[0]->id)->count();
          $jeudi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->where('id_service_source','=',$serv[0]->id)->count();
          $mercredi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->where('id_service_source','=',$serv[0]->id)->count();
          $mardi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->where('id_service_source','=',$serv[0]->id)->count();
          $lundi0 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','0')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek())->where('id_service_source','=',$serv[0]->id)->count();
          return ["vendredi0"=>$vendredi0,"jeudi0"=>$jeudi0,"mercredi0"=>$mercredi0,"mardi0"=>$mardi0,"lundi0"=>$lundi0,"flag"=>0];
         }
         if($serv[0]->urgence===1){
          $dimanche1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(6))->where('id_service_source','=',$serv[0]->id)->count();
          $samedi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(5))->where('id_service_source','=',$serv[0]->id)->count();
          $vendredi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->where('id_service_source','=',$serv[0]->id)->count();
          $jeudi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->where('id_service_source','=',$serv[0]->id)->count();
          $mercredi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->where('id_service_source','=',$serv[0]->id)->count();
          $mardi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->where('id_service_source','=',$serv[0]->id)->count();
          $lundi1 =DB::table('demandes')->select( 'demandes.id')->join('services','services.id','=','demandes.id_service_source')->where('services.urgence','=','1')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek())->where('id_service_source','=',$serv[0]->id)->count();
          return ["flag"=>1,"vendredi1"=>$vendredi1,"jeudi1"=>$jeudi1,"mercredi1"=>$mercredi1,"mardi1"=>$mardi1,"lundi1"=>$lundi1,"samedi1"=>$samedi1,"dimanche1"=>$dimanche1];
        
        }
      }
      public function TempeAttentePatientM(){
    
        $maj=Auth::user()->id;
        $serv=DB::select('select DISTINCT services.id as id ,
        services.intitule,
        services.urgence as urgence
        from services,users
        where users.id = services.user_id and
        users.id='.$maj.' and
        services.deleted_at is NULL');
        $demandesVendredi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Vendredi1_enAttente=0;
         $Vendredi1_enTraitement=0;
         $attenteVendredi1=0;
         $Vendredi1=false;
         $countDemandesVendredi1=0;
        foreach ($demandesVendredi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Vendredi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Vendredi1) { $attenteVendredi1+=$Vendredi1_enAttente->diffInMinutes($Vendredi1_enTraitement);$f1=false;$countDemandesVendredi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Vendredi1_enAttente= Carbon::parse($c[0]->created_at);
          $Vendredi1_enAttente=Carbon::parse($c[0]->created_at); $Vendredi1=true;
        
          }
           }
           
         }
         $countDemandesVendredi1!=0 ? $attenteVendredi1/=$countDemandesVendredi1 : $attenteVendredi1/=1;
         //Jeud1
         $demandesJeudi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Jeudi1_enAttente=0;
         $Jeudi1_enTraitement=0;
         $attenteJeudi1=0;
         $Jeudi1=false;
         $countDemandesJeudi1=0;
        foreach ($demandesJeudi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Jeudi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Jeudi1) { $attenteJeudi1+=$Jeudi1_enAttente->diffInMinutes($Jeudi1_enTraitement);$f1=false;$countDemandesJeudi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Jeudi1_enAttente= Carbon::parse($c[0]->created_at);
          $Jeudi1_enAttente=Carbon::parse($c[0]->created_at); $Jeudi1=true;
        
          }
           }
           
         }
         $countDemandesJeudi1!=0 ? $attenteJeudi1/=$countDemandesJeudi1 : $attenteJeudi1/=1;
    
         $demandesMercredi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Mercredi1_enAttente=0;
         $Mercredi1_enTraitement=0;
         $attenteMercredi1=0;
         $Mercredi1=false;
         $countDemandesMercredi1=0;
        foreach ($demandesMercredi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mercredi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mercredi1) { $attenteMercredi1+=$Mercredi1_enAttente->diffInMinutes($Mercredi1_enTraitement);$f1=false;$countDemandesMercredi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mercredi1_enAttente= Carbon::parse($c[0]->created_at);
          $Mercredi1_enAttente=Carbon::parse($c[0]->created_at); $Mercredi1=true;
        
          }
           }
           
         }
       $countDemandesMercredi1!=0 ? $attenteMercredi1/=$countDemandesMercredi1 : $attenteMercredi1/=1;
    
    
       $demandesMardi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Mardi1_enAttente=0;
         $Mardi1_enTraitement=0;
         $attenteMardi1=0;
         $Mardi1=false;
         $countDemandesMardi1=0;
        foreach ($demandesMardi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mardi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mardi1) { $attenteMardi1+=$Mardi1_enAttente->diffInMinutes($Mardi1_enTraitement);$f1=false;$countDemandesMardi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mardi1_enAttente= Carbon::parse($c[0]->created_at);
          $Mardi1_enAttente=Carbon::parse($c[0]->created_at); $Mardi1=true;
        
          }
           }
           
         }
       $countDemandesMardi1!=0 ? $attenteMardi1/=$countDemandesMardi1 : $attenteMardi1/=1;
    
       $demandesLundi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(0))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Lundi1_enAttente=0;
         $Lundi1_enTraitement=0;
         $attenteLundi1=0;
         $Lundi1=false;
         $countDemandesLundi1=0;
        foreach ($demandesLundi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Lundi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Lundi1) { $attenteLundi1+=$Lundi1_enAttente->diffInMinutes($Lundi1_enTraitement);$f1=false;$countDemandesLundi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Lundi1_enAttente= Carbon::parse($c[0]->created_at);
          $Lundi1_enAttente=Carbon::parse($c[0]->created_at); $Lundi1=true;
        
          }
           }
           
         }
       $countDemandesLundi1!=0 ? $attenteLundi1/=$countDemandesLundi1 : $attenteLundi1/=1;
       $demandesSamedi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(6))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
          $Samedi1_enAttente=0;
           $Samedi1_enTraitement=0;
           $attenteSamedi1=0;
           $Samedi1=false;
           $countDemandesSamedi1=0;
          foreach ($demandesSamedi1 as $demande) 
          {
              $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
           foreach($etats as $etat){
            if($etat->libelle=="En traitement"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Samedi1_enTraitement=Carbon::parse($c[0]->created_at); 
          if($Samedi1) { $attenteSamedi1+=$Samedi1_enAttente->diffInMinutes($Samedi1_enTraitement);$f1=false;$countDemandesSamedi1+=1;}  
             }
               if($etat->libelle=="En attente"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
            $Samedi1_enAttente= Carbon::parse($c[0]->created_at);
            $Samedi1_enAttente=Carbon::parse($c[0]->created_at); $Samedi1=true;
          
            }
             }
             
           }
         $countDemandesSamedi1!=0 ? $attenteSamedi1/=$countDemandesSamedi1 : $attenteSamedi1/=1;
    
    
    
         $demandesDimanche1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
         $Dimanche1_enAttente=0;
          $Dimanche1_enTraitement=0;
          $attenteDimanche1=0;
          $Dimanche1=false;
          $countDemandesDimanche1=0;
         foreach ($demandesDimanche1 as $demande) 
         {
             $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
          foreach($etats as $etat){
           if($etat->libelle=="En traitement"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
         $Dimanche1_enTraitement=Carbon::parse($c[0]->created_at); 
         if($Dimanche1) { $attenteDimanche1+=$Dimanche1_enAttente->diffInMinutes($Dimanche1_enTraitement);$f1=false;$countDemandesDimanche1+=1;}  
            }
              if($etat->libelle=="En attente"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
           $Dimanche1_enAttente= Carbon::parse($c[0]->created_at);
           $Dimanche1_enAttente=Carbon::parse($c[0]->created_at); $Dimanche1=true;
         
           }
            }
            
          }
        $countDemandesDimanche1!=0 ? $attenteDimanche1/=$countDemandesDimanche1 : $attenteDimanche1/=1;
    
    
    
    
    
        //Last Week
    
        $demandesVendredi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(3))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Vendredi2_enAttente=0;
         $Vendredi2_enTraitement=0;
         $attenteVendredi2=0;
         $Vendredi2=false;
         $countDemandesVendredi2=0;
        foreach ($demandesVendredi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Vendredi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Vendredi2) { $attenteVendredi2+=$Vendredi2_enAttente->diffInMinutes($Vendredi2_enTraitement);$f1=false;$countDemandesVendredi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Vendredi2_enAttente= Carbon::parse($c[0]->created_at);
          $Vendredi2_enAttente=Carbon::parse($c[0]->created_at); $Vendredi2=true;
        
          }
           }
           
         }
         $countDemandesVendredi2!=0 ? $attenteVendredi2/=$countDemandesVendredi2 : $attenteVendredi2/=1;
         //Jeud1
         $demandesJeudi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(4))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Jeudi2_enAttente=0;
         $Jeudi2_enTraitement=0;
         $attenteJeudi2=0;
         $Jeudi2=false;
         $countDemandesJeudi2=0;
        foreach ($demandesJeudi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Jeudi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Jeudi2) { $attenteJeudi2+=$Jeudi2_enAttente->diffInMinutes($Jeudi2_enTraitement);$f1=false;$countDemandesJeudi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Jeudi2_enAttente= Carbon::parse($c[0]->created_at);
          $Jeudi2_enAttente=Carbon::parse($c[0]->created_at); $Jeudi2=true;
        
          }
           }
           
         }
         $countDemandesJeudi2!=0 ? $attenteJeudi2/=$countDemandesJeudi2 : $attenteJeudi2/=1;
    
         $demandesMercredi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(5))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Mercredi2_enAttente=0;
         $Mercredi2_enTraitement=0;
         $attenteMercredi2=0;
         $Mercredi2=false;
         $countDemandesMercredi2=0;
        foreach ($demandesMercredi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mercredi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mercredi2) { $attenteMercredi2+=$Mercredi2_enAttente->diffInMinutes($Mercredi2_enTraitement);$f1=false;$countDemandesMercredi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mercredi2_enAttente= Carbon::parse($c[0]->created_at);
          $Mercredi2_enAttente=Carbon::parse($c[0]->created_at); $Mercredi2=true;
        
          }
           }
           
         }
       $countDemandesMercredi2!=0 ? $attenteMercredi2/=$countDemandesMercredi2 : $attenteMercredi2/=1;
    
    
       $demandesMardi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(6))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Mardi2_enAttente=0;
         $Mardi2_enTraitement=0;
         $attenteMardi2=0;
         $Mardi2=false;
         $countDemandesMardi2=0;
        foreach ($demandesMardi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mardi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mardi2) { $attenteMardi2+=$Mardi2_enAttente->diffInMinutes($Mardi2_enTraitement);$f1=false;$countDemandesMardi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mardi2_enAttente= Carbon::parse($c[0]->created_at);
          $Mardi2_enAttente=Carbon::parse($c[0]->created_at); $Mardi2=true;
        
          }
           }
           
         }
       $countDemandesMardi2!=0 ? $attenteMardi2/=$countDemandesMardi2 : $attenteMardi2/=1;
    
       $demandesLundi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(7))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
        $Lundi2_enAttente=0;
         $Lundi2_enTraitement=0;
         $attenteLundi2=0;
         $Lundi2=false;
         $countDemandesLundi2=0;
        foreach ($demandesLundi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Lundi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Lundi2) { $attenteLundi2+=$Lundi2_enAttente->diffInMinutes($Lundi2_enTraitement);$f1=false;$countDemandesLundi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Lundi2_enAttente= Carbon::parse($c[0]->created_at);
          $Lundi2_enAttente=Carbon::parse($c[0]->created_at); $Lundi2=true;
        
          }
           }
           
         }
       $countDemandesLundi2!=0 ? $attenteLundi2/=$countDemandesLundi2 : $attenteLundi2/=1;
       $demandesSamedi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(2))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
          $Samedi2_enAttente=0;
           $Samedi2_enTraitement=0;
           $attenteSamedi2=0;
           $Samedi2=false;
           $countDemandesSamedi2=0;
          foreach ($demandesSamedi2 as $demande) 
          {
              $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
           foreach($etats as $etat){
            if($etat->libelle=="En traitement"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Samedi2_enTraitement=Carbon::parse($c[0]->created_at); 
          if($Samedi2) { $attenteSamedi2+=$Samedi2_enAttente->diffInMinutes($Samedi2_enTraitement);$f1=false;$countDemandesSamedi2+=1;}  
             }
               if($etat->libelle=="En attente"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
            $Samedi2_enAttente= Carbon::parse($c[0]->created_at);
            $Samedi2_enAttente=Carbon::parse($c[0]->created_at); $Samedi2=true;
          
            }
             }
             
           }
         $countDemandesSamedi2!=0 ? $attenteSamedi2/=$countDemandesSamedi2 : $attenteSamedi2/=1;
    
    
    
         $demandesDimanche2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(1))->whereRaw('demandes.updated_at != demandes.created_at')->where('id_service_source','=',$serv[0]->id)->get();
         $Dimanche2_enAttente=0;
          $Dimanche2_enTraitement=0;
          $attenteDimanche2=0;
          $Dimanche2=false;
          $countDemandesDimanche2=0;
         foreach ($demandesDimanche2 as $demande) 
         {
             $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
          foreach($etats as $etat){
           if($etat->libelle=="En traitement"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
         $Dimanche2_enTraitement=Carbon::parse($c[0]->created_at); 
         if($Dimanche2) { $attenteDimanche2+=$Dimanche2_enAttente->diffInMinutes($Dimanche2_enTraitement);$f1=false;$countDemandesDimanche2+=1;}  
            }
              if($etat->libelle=="En attente"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
           $Dimanche2_enAttente= Carbon::parse($c[0]->created_at);
           $Dimanche2_enAttente=Carbon::parse($c[0]->created_at); $Dimanche2=true;
         
           }
            }
            
          }
        $countDemandesDimanche2!=0 ? $attenteDimanche2/=$countDemandesDimanche2 : $attenteDimanche2/=1;
    
      
    return ["Dimanche2"=>$attenteDimanche2, "Samedi2"=>$attenteSamedi2, "Vendredi2"=>$attenteVendredi2,"Jeudi2"=>$attenteJeudi2,"Mercredi2"=>$attenteMercredi2,"Mardi2"=>$attenteMardi2,"Lundi2"=>$attenteLundi2, "Dimanche1"=>$attenteDimanche1, "Samedi1"=>$attenteSamedi1, "Vendredi1"=>$attenteVendredi1,"Jeudi1"=>$attenteJeudi1,"Mercredi1"=>$attenteMercredi1,"Mardi1"=>$attenteMardi1,"Lundi1"=>$attenteLundi1];
      }
    
      public function tauxCourses(){
        $bran=Auth::user()->id;
        $serviceVendredi=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(4))->where('user_id','=',$bran)->get();
       
        $countVendrediBran=0;
        $countVendrediServ=0;
        if(sizeof($serviceVendredi)!=0){
        $demandesVendredi= DB::table('demandes')->where('id_service_source','=',$serviceVendredi[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->get();
      
             foreach($demandesVendredi as $demande){
               if($demande->user_id_brancardier===$bran){
                $countVendrediBran+=1;
            
               }
               $countVendrediServ+=1;
             }
        
       }
       $serviceJeudi=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(3))->where('user_id','=',$bran)->get();
     
       $countJeudiBran=0;
       $countJeudiServ=0;
       if(sizeof($serviceJeudi)!=0){
        $demandesJeudi= DB::table('demandes')->where('id_service_source','=',$serviceJeudi[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->get();
    
            foreach($demandesJeudi as $demande){
              if($demande->user_id_brancardier===$bran){
               $countJeudiBran+=1;
           
              }
              $countJeudiServ+=1;
            }
        
      }
    
      $serviceMercredi=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(2))->where('user_id','=',$bran)->get();
      
      $countMercrediBran=0;
    $countMercrediServ=0;
      if(sizeof($serviceMercredi)!=0){
      $demandesMercredi= DB::table('demandes')->where('id_service_source','=',$serviceMercredi[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->get();
    
     foreach($demandesMercredi as $demande){
       if($demande->user_id_brancardier===$bran){
        $countMercrediBran+=1;
    
       }
       $countMercrediServ+=1;
     }
    }
    
     $serviceMardi=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(1))->where('user_id','=',$bran)->get();
     $countMardiBran=0;
    $countMardiServ=0;
     if(sizeof($serviceMardi)!=0){
     $demandesMardi= DB::table('demandes')->where('id_service_source','=',$serviceMardi[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->get();
    
    foreach($demandesMardi as $demande){
      if($demande->user_id_brancardier===$bran){
       $countMardiBran+=1;
    
      }
      $countMardiServ+=1;
    }
    }
    
    $serviceLundi=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(0))->where('user_id','=',$bran)->get();
    $countLundiBran=0;
    $countLundiServ=0;
    if(sizeof($serviceLundi)!=0){
    
    $demandesLundi= DB::table('demandes')->where('id_service_source','=',$serviceLundi[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(0))->get();
    
    foreach($demandesLundi as $demande){
     if($demande->user_id_brancardier===$bran){
      $countLundiBran+=1;
    
     }
     $countLundiServ+=1;
    }
    
    }
      
    $serviceSamedi=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(5))->where('user_id','=',$bran)->get();
    $countSamediBran=0;
    $countSamediServ=0;
    if(sizeof($serviceSamedi)!=0){
    
    $demandesSamedi= DB::table('demandes')->where('id_service_source','=',$serviceSamedi[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(5))->get();
    foreach($demandesSamedi as $demande){
    if($demande->user_id_brancardier===$bran){
     $countSamediBran+=1;
    
    }
    $countSamediServ+=1;
    }
    }
    $serviceDimanche=DB::table('service_user')->select('service_id')->whereDate('date_debut','=',Carbon::now()->startOfWeek()->addDays(0))->where('user_id','=',$bran)->get();
    $countDimancheBran=0;
    $countDimancheServ=0;
    if(sizeof($serviceDimanche)!=0){
    
    $demandesDimanche= DB::table('demandes')->where('id_service_source','=', $serviceDimanche[0]->service_id)->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(6))->get();
    
    foreach($demandesDimanche as $demande){
    if($demande->user_id_brancardier===$bran){
    $countDimancheBran+=1;
    
    }
    $countDimancheServ+=1;
    }
    }
        return["countDimancheBran"=>$countDimancheBran,"countDimancheServ"=>$countDimancheServ,"countSamediBran"=>$countSamediBran,"countSamediServ"=>$countSamediServ,"countLundiBran"=>$countLundiBran,"countLundiServ"=>$countLundiServ,"countMardiBran"=>$countMardiBran,"countMardiServ"=>$countMardiServ,"countMercrediBran"=>$countMercrediBran,"countMercrediServ"=>$countMercrediServ,"countVendrediBran"=>$countVendrediBran,"countVendrediServ"=>$countVendrediServ,"countJeudiBran"=>$countJeudiBran,"countJeudiServ"=>$countJeudiServ];
      }
      public function TempeAttentePatient(){
     
        $demandesVendredi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(4))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Vendredi1_enAttente=0;
         $Vendredi1_enTraitement=0;
         $attenteVendredi1=0;
         $Vendredi1=false;
         $countDemandesVendredi1=0;
        foreach ($demandesVendredi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Vendredi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Vendredi1) { $attenteVendredi1+=$Vendredi1_enAttente->diffInMinutes($Vendredi1_enTraitement);$f1=false;$countDemandesVendredi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Vendredi1_enAttente= Carbon::parse($c[0]->created_at);
          $Vendredi1_enAttente=Carbon::parse($c[0]->created_at); $Vendredi1=true;
        
          }
           }
           
         }
         $countDemandesVendredi1!=0 ? $attenteVendredi1/=$countDemandesVendredi1 : $attenteVendredi1/=1;
         //Jeud1
         $demandesJeudi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(3))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Jeudi1_enAttente=0;
         $Jeudi1_enTraitement=0;
         $attenteJeudi1=0;
         $Jeudi1=false;
         $countDemandesJeudi1=0;
        foreach ($demandesJeudi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Jeudi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Jeudi1) { $attenteJeudi1+=$Jeudi1_enAttente->diffInMinutes($Jeudi1_enTraitement);$f1=false;$countDemandesJeudi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Jeudi1_enAttente= Carbon::parse($c[0]->created_at);
          $Jeudi1_enAttente=Carbon::parse($c[0]->created_at); $Jeudi1=true;
        
          }
           }
           
         }
         $countDemandesJeudi1!=0 ? $attenteJeudi1/=$countDemandesJeudi1 : $attenteJeudi1/=1;
  
         $demandesMercredi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Mercredi1_enAttente=0;
         $Mercredi1_enTraitement=0;
         $attenteMercredi1=0;
         $Mercredi1=false;
         $countDemandesMercredi1=0;
        foreach ($demandesMercredi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mercredi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mercredi1) { $attenteMercredi1+=$Mercredi1_enAttente->diffInMinutes($Mercredi1_enTraitement);$f1=false;$countDemandesMercredi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mercredi1_enAttente= Carbon::parse($c[0]->created_at);
          $Mercredi1_enAttente=Carbon::parse($c[0]->created_at); $Mercredi1=true;
        
          }
           }
           
         }
       $countDemandesMercredi1!=0 ? $attenteMercredi1/=$countDemandesMercredi1 : $attenteMercredi1/=1;
  
  
       $demandesMardi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(1))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Mardi1_enAttente=0;
         $Mardi1_enTraitement=0;
         $attenteMardi1=0;
         $Mardi1=false;
         $countDemandesMardi1=0;
        foreach ($demandesMardi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mardi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mardi1) { $attenteMardi1+=$Mardi1_enAttente->diffInMinutes($Mardi1_enTraitement);$f1=false;$countDemandesMardi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mardi1_enAttente= Carbon::parse($c[0]->created_at);
          $Mardi1_enAttente=Carbon::parse($c[0]->created_at); $Mardi1=true;
        
          }
           }
           
         }
       $countDemandesMardi1!=0 ? $attenteMardi1/=$countDemandesMardi1 : $attenteMardi1/=1;
  
       $demandesLundi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(0))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Lundi1_enAttente=0;
         $Lundi1_enTraitement=0;
         $attenteLundi1=0;
         $Lundi1=false;
         $countDemandesLundi1=0;
        foreach ($demandesLundi1 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Lundi1_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Lundi1) { $attenteLundi1+=$Lundi1_enAttente->diffInMinutes($Lundi1_enTraitement);$f1=false;$countDemandesLundi1+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Lundi1_enAttente= Carbon::parse($c[0]->created_at);
          $Lundi1_enAttente=Carbon::parse($c[0]->created_at); $Lundi1=true;
        
          }
           }
           
         }
       $countDemandesLundi1!=0 ? $attenteLundi1/=$countDemandesLundi1 : $attenteLundi1/=1;
       $demandesSamedi1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(6))->whereRaw('demandes.updated_at != demandes.created_at')->get();
          $Samedi1_enAttente=0;
           $Samedi1_enTraitement=0;
           $attenteSamedi1=0;
           $Samedi1=false;
           $countDemandesSamedi1=0;
          foreach ($demandesSamedi1 as $demande) 
          {
              $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
           foreach($etats as $etat){
            if($etat->libelle=="En traitement"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Samedi1_enTraitement=Carbon::parse($c[0]->created_at); 
          if($Samedi1) { $attenteSamedi1+=$Samedi1_enAttente->diffInMinutes($Samedi1_enTraitement);$f1=false;$countDemandesSamedi1+=1;}  
             }
               if($etat->libelle=="En attente"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
            $Samedi1_enAttente= Carbon::parse($c[0]->created_at);
            $Samedi1_enAttente=Carbon::parse($c[0]->created_at); $Samedi1=true;
          
            }
             }
             
           }
         $countDemandesSamedi1!=0 ? $attenteSamedi1/=$countDemandesSamedi1 : $attenteSamedi1/=1;
  
  
  
         $demandesDimanche1= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->addDays(2))->whereRaw('demandes.updated_at != demandes.created_at')->get();
         $Dimanche1_enAttente=0;
          $Dimanche1_enTraitement=0;
          $attenteDimanche1=0;
          $Dimanche1=false;
          $countDemandesDimanche1=0;
         foreach ($demandesDimanche1 as $demande) 
         {
             $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
          foreach($etats as $etat){
           if($etat->libelle=="En traitement"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
         $Dimanche1_enTraitement=Carbon::parse($c[0]->created_at); 
         if($Dimanche1) { $attenteDimanche1+=$Dimanche1_enAttente->diffInMinutes($Dimanche1_enTraitement);$f1=false;$countDemandesDimanche1+=1;}  
            }
              if($etat->libelle=="En attente"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
           $Dimanche1_enAttente= Carbon::parse($c[0]->created_at);
           $Dimanche1_enAttente=Carbon::parse($c[0]->created_at); $Dimanche1=true;
         
           }
            }
            
          }
        $countDemandesDimanche1!=0 ? $attenteDimanche1/=$countDemandesDimanche1 : $attenteDimanche1/=1;
  
  
  
  
        //Last Week
  
        $demandesVendredi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(3))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Vendredi2_enAttente=0;
         $Vendredi2_enTraitement=0;
         $attenteVendredi2=0;
         $Vendredi2=false;
         $countDemandesVendredi2=0;
        foreach ($demandesVendredi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Vendredi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Vendredi2) { $attenteVendredi2+=$Vendredi2_enAttente->diffInMinutes($Vendredi2_enTraitement);$f1=false;$countDemandesVendredi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Vendredi2_enAttente= Carbon::parse($c[0]->created_at);
          $Vendredi2_enAttente=Carbon::parse($c[0]->created_at); $Vendredi2=true;
        
          }
           }
           
         }
         $countDemandesVendredi2!=0 ? $attenteVendredi2/=$countDemandesVendredi2 : $attenteVendredi2/=1;
         //Jeud1
         $demandesJeudi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(4))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Jeudi2_enAttente=0;
         $Jeudi2_enTraitement=0;
         $attenteJeudi2=0;
         $Jeudi2=false;
         $countDemandesJeudi2=0;
        foreach ($demandesJeudi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Jeudi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Jeudi2) { $attenteJeudi2+=$Jeudi2_enAttente->diffInMinutes($Jeudi2_enTraitement);$f1=false;$countDemandesJeudi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Jeudi2_enAttente= Carbon::parse($c[0]->created_at);
          $Jeudi2_enAttente=Carbon::parse($c[0]->created_at); $Jeudi2=true;
        
          }
           }
           
         }
         $countDemandesJeudi2!=0 ? $attenteJeudi2/=$countDemandesJeudi2 : $attenteJeudi2/=1;
  
         $demandesMercredi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(5))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Mercredi2_enAttente=0;
         $Mercredi2_enTraitement=0;
         $attenteMercredi2=0;
         $Mercredi2=false;
         $countDemandesMercredi2=0;
        foreach ($demandesMercredi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mercredi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mercredi2) { $attenteMercredi2+=$Mercredi2_enAttente->diffInMinutes($Mercredi2_enTraitement);$f1=false;$countDemandesMercredi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mercredi2_enAttente= Carbon::parse($c[0]->created_at);
          $Mercredi2_enAttente=Carbon::parse($c[0]->created_at); $Mercredi2=true;
        
          }
           }
           
         }
       $countDemandesMercredi2!=0 ? $attenteMercredi2/=$countDemandesMercredi2 : $attenteMercredi2/=1;
  
  
       $demandesMardi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(6))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Mardi2_enAttente=0;
         $Mardi2_enTraitement=0;
         $attenteMardi2=0;
         $Mardi2=false;
         $countDemandesMardi2=0;
        foreach ($demandesMardi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Mardi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Mardi2) { $attenteMardi2+=$Mardi2_enAttente->diffInMinutes($Mardi2_enTraitement);$f1=false;$countDemandesMardi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Mardi2_enAttente= Carbon::parse($c[0]->created_at);
          $Mardi2_enAttente=Carbon::parse($c[0]->created_at); $Mardi2=true;
        
          }
           }
           
         }
       $countDemandesMardi2!=0 ? $attenteMardi2/=$countDemandesMardi2 : $attenteMardi2/=1;
  
       $demandesLundi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(7))->whereRaw('demandes.updated_at != demandes.created_at')->get();
        $Lundi2_enAttente=0;
         $Lundi2_enTraitement=0;
         $attenteLundi2=0;
         $Lundi2=false;
         $countDemandesLundi2=0;
        foreach ($demandesLundi2 as $demande) 
        {
            $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
         foreach($etats as $etat){
          if($etat->libelle=="En traitement"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
        $Lundi2_enTraitement=Carbon::parse($c[0]->created_at); 
        if($Lundi2) { $attenteLundi2+=$Lundi2_enAttente->diffInMinutes($Lundi2_enTraitement);$f1=false;$countDemandesLundi2+=1;}  
           }
             if($etat->libelle=="En attente"){
            $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Lundi2_enAttente= Carbon::parse($c[0]->created_at);
          $Lundi2_enAttente=Carbon::parse($c[0]->created_at); $Lundi2=true;
        
          }
           }
           
         }
       $countDemandesLundi2!=0 ? $attenteLundi2/=$countDemandesLundi2 : $attenteLundi2/=1;
       $demandesSamedi2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(2))->whereRaw('demandes.updated_at != demandes.created_at')->get();
          $Samedi2_enAttente=0;
           $Samedi2_enTraitement=0;
           $attenteSamedi2=0;
           $Samedi2=false;
           $countDemandesSamedi2=0;
          foreach ($demandesSamedi2 as $demande) 
          {
              $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
           foreach($etats as $etat){
            if($etat->libelle=="En traitement"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
          $Samedi2_enTraitement=Carbon::parse($c[0]->created_at); 
          if($Samedi2) { $attenteSamedi2+=$Samedi2_enAttente->diffInMinutes($Samedi2_enTraitement);$f1=false;$countDemandesSamedi2+=1;}  
             }
               if($etat->libelle=="En attente"){
              $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
            $Samedi2_enAttente= Carbon::parse($c[0]->created_at);
            $Samedi2_enAttente=Carbon::parse($c[0]->created_at); $Samedi2=true;
          
            }
             }
             
           }
         $countDemandesSamedi2!=0 ? $attenteSamedi2/=$countDemandesSamedi2 : $attenteSamedi2/=1;
  
  
  
         $demandesDimanche2= DB::table('demandes')->whereDate('demandes.created_at', '=', Carbon::now()->startOfWeek()->subDays(1))->whereRaw('demandes.updated_at != demandes.created_at')->get();
         $Dimanche2_enAttente=0;
          $Dimanche2_enTraitement=0;
          $attenteDimanche2=0;
          $Dimanche2=false;
          $countDemandesDimanche2=0;
         foreach ($demandesDimanche2 as $demande) 
         {
             $etats = Demande::find($demande->id)->etats()->orderBy('etat_demande.id', 'asc')->get();
          foreach($etats as $etat){
           if($etat->libelle=="En traitement"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
         $Dimanche2_enTraitement=Carbon::parse($c[0]->created_at); 
         if($Dimanche2) { $attenteDimanche2+=$Dimanche2_enAttente->diffInMinutes($Dimanche2_enTraitement);$f1=false;$countDemandesDimanche2+=1;}  
            }
              if($etat->libelle=="En attente"){
             $c=DB::table('etat_demande')->select('created_at')->where('demande_id','=',$demande->id)->where('etat_id','=',$etat->id)->get();
           $Dimanche2_enAttente= Carbon::parse($c[0]->created_at);
           $Dimanche2_enAttente=Carbon::parse($c[0]->created_at); $Dimanche2=true;
         
           }
            }
            
          }
        $countDemandesDimanche2!=0 ? $attenteDimanche2/=$countDemandesDimanche2 : $attenteDimanche2/=1;
  
      
  return ["Dimanche2"=>$attenteDimanche2, "Samedi2"=>$attenteSamedi2, "Vendredi2"=>$attenteVendredi2,"Jeudi2"=>$attenteJeudi2,"Mercredi2"=>$attenteMercredi2,"Mardi2"=>$attenteMardi2,"Lundi2"=>$attenteLundi2, "Dimanche1"=>$attenteDimanche1, "Samedi1"=>$attenteSamedi1, "Vendredi1"=>$attenteVendredi1,"Jeudi1"=>$attenteJeudi1,"Mercredi1"=>$attenteMercredi1,"Mardi1"=>$attenteMardi1,"Lundi1"=>$attenteLundi1];
      }
  

    public function updateDemande(Request $request)
    {
            $id_bran=$request['selectedItem'];  
            $demande=Demande::findOrFail($request['id_demande']);
            $demande->user_id_brancardier=$id_bran;
            $demande->save();
            $demande->etats()->attach(Etat::where('libelle','En traitement')->first());
           
            return $demande;
            
    }
}
