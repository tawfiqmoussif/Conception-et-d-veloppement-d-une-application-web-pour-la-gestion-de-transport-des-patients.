<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demande extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function demandeur(){
        return $this->belongsTo('App\User', 'user_id_demandeur','id');
    }
    public function brancardier(){
        return $this->belongsTo('App\User', 'user_id_brancardier','id');
    }

    public function etats(){
        return $this->belongsToMany('App\Etat','etat_demande','demande_id','etat_id');
    }
    public function hospitalisation(){
        return $this->belongsTo('App\Hospitalisation','hospitalisation_id','id');
    }
    public function service_source(){
        return $this->belongsTo('App\Service', 'id_service_source','id');
    }
    public function service_destination(){
        return $this->belongsTo('App\Service', 'id_service_destination','id');
    }
}
