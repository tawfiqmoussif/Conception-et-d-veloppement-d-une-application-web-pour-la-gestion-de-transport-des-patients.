<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospitalisation extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    
    public function demandes(){
        return $this->hasMany('App\Demande');
    }
}
