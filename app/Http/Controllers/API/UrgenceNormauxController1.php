<?php



namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\database\migrations\service_user;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use App\DayAffectation;
use Carbon\CarbonImmutable;
use Carbon\Carbon;






class UrgenceNormauxController1 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("select  users.id
        from users
        where users.metier = 'Brancardier'");
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


    public function branAffectation(Request $request)
    {
    //gestion des groupes d'affectation

    $DateDebut=$request['DateDebut'];
    $DateFin=$request['DateFin'];    
    $date1 = Carbon::parse($DateFin);
    $date2 = Carbon::parse($DateDebut);
    $nbdays = $request['diffDays'];;

    //$nbdays = $date1->diffInDays($date2);
   
       $t=0;
       $t1=0;
       $t2=0;
       $t3=0;
       $bar=$request['selectedItem']; 
       $tab=array();
       foreach($bar as $b){
        array_push($tab,$b); 
       }  
        
        $quotient=(sizeof($tab)/3);
        $brangrp1=array();
        $brangrp2=array();
        $brangrp3=array();
       
        if((sizeof($tab)%3)==0){
            for($id=0;$id<sizeof($tab);$id++){
               if($t<$quotient){
                    $brangrp1[$t1]=$tab[$id];
                      $t1++;     
                      $t++;                                
              }
              elseif($t<($quotient*2) && $quotient<=$t){
                $brangrp2[$t2]=$tab[$id];
                $t2++;
                $t++;  
              }
              elseif($t<($quotient*3) && ($quotient*2)<=$t){
                $brangrp3[$t3]=$tab[$id];
                $t3++;
                $t++;  
              }
            }        
        }        
        // return ['resultat'=>$bar];


        //gestion des horaires
       /* $day=array();
        $nbdays=$request['diffDays'];   
        $i=0;
        while($i<$nbdays){
           if($i%3==0){
               for($z=0;$z<sizeof($brangrp1);$z++){
                $day[i][0][$z]=$brangrp1[$z];
                $day[i][1][$z]=$brangrp2[$z];
                $i++;
            }
           }
           if($i%3==1){
            for($z=0;$z<sizeof($brangrp1);$z++){
                $day[i][0][$z]=$brangrp3[$z];
                $day[i][1][$z]=$brangrp1[$z];
                $i++;
            }
            }
            
            if($i%3==2){
            for($z=0;$z<sizeof($brangrp1);$z++){
                $day[i][0][$z]=$brangrp2[$z];
                $day[i][1][$z]=$brangrp3[$z];
                $i++;
            }
            }
        }*/


       
       // $nbdays=$request['diffDays'];   
        $i=0;
        while($i<$nbdays){
            


                  if($i%3==0 && $i<$nbdays){
                            $aff[$i]= new DayAffectation();   
                            $aff[$i]->jour=$i;
                            $aff[$i]->temps=0;
                            $aff[$i]->groupe=$brangrp1;
                        // $aff[$i]->dd=Carbon::parse($date2->addDays($i));
                        // $aff[$i]->df=Carbon::parse($date2->addDays($i));
                            $aff[$i]->dd=(Carbon::parse(($DateDebut." "."08:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                            $aff[$i]->df=(Carbon::parse(($DateDebut." "."18:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                            $j=$i+1;
                            $aff[$j+$nbdays]= new DayAffectation();        
                            $aff[$j+$nbdays]->jour=$i;
                            $aff[$j+$nbdays]->temps=1;
                            $aff[$j+$nbdays]->groupe=$brangrp2;
                        //  $aff[$j+$nbdays]->dd=Carbon::parse($date2->addDays($i));
                        //  $aff[$j+$nbdays]->df=Carbon::parse($date2->addDays($i+1));
                            $aff[$j+$nbdays]->dd=(Carbon::parse(($DateDebut." "."18:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                            $aff[$j+$nbdays]->df=(Carbon::parse(($DateDebut." "."08:00"))->addDays($i+1))->isoFormat('YYYY-MM-DD HH:mm:ss');

                            $i++;               
                    }
                    if($i%3==1 && $i<$nbdays){                       

                            $aff[$i]= new DayAffectation();   
                                $aff[$i]->jour=$i;
                                $aff[$i]->temps=0;
                                $aff[$i]->groupe=$brangrp3;
                              //  $aff[$i]->dd=Carbon::parse($date2->addDays($i-1));
                               // $aff[$i]->df=Carbon::parse($date2->addDays($i-1));
                                $aff[$i]->dd=(Carbon::parse(($DateDebut." "."08:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $aff[$i]->df=(Carbon::parse(($DateDebut." "."18:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $j=$i+1;
                                $aff[$j+$nbdays+1]= new DayAffectation();        
                                $aff[$j+$nbdays+1]->jour=$i;
                                $aff[$j+$nbdays+1]->temps=1;
                                $aff[$j+$nbdays+1]->groupe=$brangrp1;
                              //  $aff[$j+$nbdays+1]->dd=Carbon::parse($date2->addDays($i-1));
                              //  $aff[$j+$nbdays+1]->df=Carbon::parse($date2->addDays($i));
                                $aff[$j+$nbdays+1]->dd=(Carbon::parse(($DateDebut." "."18:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $aff[$j+$nbdays+1]->df=(Carbon::parse(($DateDebut." "."08:00"))->addDays($i+1))->isoFormat('YYYY-MM-DD HH:mm:ss');


                                $i++;
                    }
                      if($i%3==2 && $i<$nbdays){
                            $aff[$i]= new DayAffectation();   
                                $aff[$i]->jour=$i;
                                $aff[$i]->temps=0;
                                $aff[$i]->groupe=$brangrp2;
                              //  $aff[$i]->dd=Carbon::parse($date2->addDays($i-2));
                               // $aff[$i]->df=Carbon::parse($date2->addDays($i-2));
                                $aff[$i]->dd=(Carbon::parse(($DateDebut." "."08:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $aff[$i]->df=(Carbon::parse(($DateDebut." "."18:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $j=$i+1;
                                $aff[$j+$nbdays+2]= new DayAffectation();        
                                $aff[$j+$nbdays+2]->jour=$i;
                                $aff[$j+$nbdays+2]->temps=1;
                                $aff[$j+$nbdays+2]->groupe=$brangrp3;
                              //  $aff[$j+$nbdays+2]->dd=Carbon::parse($date2->addDays($i-2));
                               // $aff[$j+$nbdays+2]->df=Carbon::parse($date2->addDays($i-1));
                                $aff[$j+$nbdays+2]->dd=(Carbon::parse(($DateDebut." "."18:00"))->addDays($i))->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $aff[$j+$nbdays+2]->df=(Carbon::parse(($DateDebut." "."08:00"))->addDays($i+1))->isoFormat('YYYY-MM-DD HH:mm:ss');

                                $i++;
                               
                            }
                         
                            
                                               
                            

    
            }
            $id_services= DB::select("select services.id
            from services
            where services.urgence = '1'");
            foreach($aff as $a){
                for($j=0;$j<sizeof($brangrp3);$j++){
                    $bran =User::findOrFail($a->groupe[$j]);
                    $bran->services()->attach($id_services[0],['date_debut'=>$a->dd,'date_fin' =>$a->df,'weekend' =>0]);   
                }
            }
            return ['resultat'=>$aff];
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
