<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etat extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function demandes(){
        return $this->belongsToMany('App\Demande');
    }
}
