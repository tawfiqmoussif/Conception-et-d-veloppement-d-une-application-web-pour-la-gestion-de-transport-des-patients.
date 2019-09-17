<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function hopital(){
        return $this->belongsTo('App\Hopital');
    }

    public function lits(){
        return $this->hasMany('App\Lit');
    }
    public function users(){
        return $this->belongsToMany('App\User');
    }
    public function user()
    {
        return $this->hasOne('App\User');
    }
    public function demandes(){
        return $this->hasMany('App\Demande');
    }

}
