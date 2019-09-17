<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BrancardierController;
use App\User;
use App\Role;
use App\Service;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Carbon\CarbonImmutable;
use Carbon\Carbon;


class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            $lVendredi =DB::table('users')->select( 'users.id',
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
            ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(3))->get();
            $lJeudi =DB::table('users')->select( 'users.id',
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
            ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(4))->get(); 
            $lMercredi =DB::table('users')->select( 'users.id',
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
            ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(5))->get(); 
            $lMardi =DB::table('users')->select( 'users.id',
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
            ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(6))->get();
            $lLundi =DB::table('users')->select( 'users.id',
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
            ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','0')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7))->get(); 
    
        
            $vendredi =DB::table('users')->select( 'users.id',
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
            $jeudi =DB::table('users')->select( 'users.id',
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
            $mercredi =DB::table('users')->select( 'users.id',
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
            $mardi =DB::table('users')->select( 'users.id',
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
            $lundi =DB::table('users')->select( 'users.id',
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
    
            return ['lLundi' =>$lLundi,'lMardi' =>$lMardi,'lMercredi' =>$lMercredi,'lJeudi' =>$lJeudi,'lVendredi' =>$lVendredi,'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi];  
    }


    
    public function showUrgence($id)
    {
        $lDimanche =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(1))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(1)->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lSamedi =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(2))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(2)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lVendredi =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(3))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(3)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lJeudi =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(4))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(4)->add('08 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $lMercredi =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(5))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(5)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get(); 
        $lMardi =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(6))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(6)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
        $lLundi =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(7))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(7)->add('8 hours 00 minutes')->isoFormat('YYYY-MM-DD HH:mm:ss'))->get();
      
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
    


        $ldimanche1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek())->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(1)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
        $lsamedi1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(1))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(2)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
        $lvendredi1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(2))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(3)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
        $ljeudi1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(4)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
        $lmercredi1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(5)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
        $lmardi1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->startOfHour()->subDays(6)->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
        $llundi1 =DB::table('users')->select( 'service_user.user_id',
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
        ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->whereDate('service_user.date_Fin', '=', Carbon::now()->startOfWeek()->subDays(6))->where('service_user.date_debut', '=', Carbon::now()->startOfWeek()->subDays(7)->startOfHour()->add('18 hours 00 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
        
        
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

    $lvendrediTemp =DB::table('users')->select( 'service_user.user_id',
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
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(3)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    $ljeudiTemp =DB::table('users')->select( 'service_user.user_id',
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
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(4)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
    $lmercrediTemp =DB::table('users')->select( 'service_user.user_id',
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
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(5)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get(); 
    $lmardiTemp =DB::table('users')->select( 'service_user.user_id',
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
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(6)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();
    $llundiTemp =DB::table('users')->select( 'service_user.user_id',
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
    ->join('services','services.id','=','service_user.service_id')->where('services.urgence','=','1')->where('services.id','=',$id)->where('service_user.date_debut','=',Carbon::now()->startOfWeek()->startOfHour()->subDays(7)->add('16 hours 30 minutes')->isoFormat('YYYY-MM-DD H:mm:ss'))->get();

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
            return ['lLundi' =>$lLundi,'lMardi' =>$lMardi,'lMercredi' =>$lMercredi,'lJeudi' =>$lJeudi,'lVendredi' =>$lVendredi,'lSamedi' =>$lSamedi,'lDimanche' =>$lDimanche,
            'lundi' =>$lundi,'mardi' =>$mardi,'mercredi' =>$mercredi,'jeudi' =>$jeudi,'vendredi' =>$vendredi,'samedi' =>$samedi,'dimanche' =>$dimanche,
            'llundi1' =>$llundi1,'lmardi1' =>$lmardi1,'lmercredi1' =>$lmercredi1,'ljeudi1' =>$ljeudi1,'lvendredi1' =>$lvendredi1,'lsamedi1' =>$lsamedi1,'ldimanche1' =>$ldimanche1,
            'lundi1' =>$lundi1,'mardi1' =>$mardi1,'mercredi1' =>$mercredi1,'jeudi1' =>$jeudi1,'vendredi1' =>$vendredi1,'samedi1' =>$samedi1,'dimanche1' =>$dimanche1,
            'llundiTemp' =>$llundiTemp,'lmardiTemp' =>$lmardiTemp,'lmercrediTemp' =>$lmercrediTemp,'ljeudiTemp' =>$ljeudiTemp,'lvendrediTemp' =>$lvendrediTemp,
            'lundiTemp' =>$lundiTemp,'mardiTemp' =>$mardiTemp,'mercrediTemp' =>$mercrediTemp,'jeudiTemp' =>$jeudiTemp,'vendrediTemp' =>$vendrediTemp];  
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
