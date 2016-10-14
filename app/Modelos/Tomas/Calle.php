<?php

namespace App\Modelos\Tomas;

use Illuminate\Database\Eloquent\Model;

class Calle extends Model
{
    protected $table = "calle";
    protected $primaryKey = "idcalle";
    public $timestamps = false;


    public function barrio(){
        return $this->belongsTo('App\Modelos\Sectores\Barrio','idbarrio');
    }

    public function canales(){
        return $this->hasMany('App\Modelos\Tomas\Canal','idcalle');
    }

}
