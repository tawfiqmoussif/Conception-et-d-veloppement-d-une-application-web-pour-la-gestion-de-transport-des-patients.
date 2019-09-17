<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayAffectation extends Model
{
    protected $jour = 'integer';
    protected $temps = 'integer';
    protected $groupe = 'array()';
    protected $dd = '';
    protected $df = '';
    protected $fillable = [
        'jour', 'temps', 'groupe','dd','df',
    ];
  
}
