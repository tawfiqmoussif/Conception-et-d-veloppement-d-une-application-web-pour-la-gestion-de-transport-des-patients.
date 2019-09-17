<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lit extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function service(){
        return $this->belongsTo('App\Service');
    }

    public function patients(){
        return $this->belongsToMany('App\Patient');
    }
}
