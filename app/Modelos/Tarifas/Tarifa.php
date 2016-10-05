<?php

namespace App\Modelos\Tarifas;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table = 'tarifa';
    protected $primaryKey = 'idtarifa';
    public $timestamps = false;


    public function terreno()
    {
        return $this->hasMany('App\Modelos\Terreno\Terreno', 'idtarifa');
    }

    public function area()
    {
        return $this->hasMany('App\Modelos\Tarifas\Area', 'idtarifa');
    }

    public function caudal()
    {
        return $this->hasMany('App\Modelos\Tarifas\Caudal', 'idtarifa');
    }

}
