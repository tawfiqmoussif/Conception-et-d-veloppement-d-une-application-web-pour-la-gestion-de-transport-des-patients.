<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hopital extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function services(){
        return $this->hasMany('App\Service');
    }
}

