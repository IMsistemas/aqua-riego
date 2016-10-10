<?php

namespace App\Modelos\Terreno;

use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    protected $table = 'cultivo';
    protected $primaryKey = 'idcultivo';
    public $timestamps = false;

    public function terreno()
    {
        return $this->hasMany('App\Modelos\Terreno\Terreno', 'idcultivo');
    }

    public function tarifa()
    {
        return $this->hasMany('App\Modelos\Tarifas\Tarifa', 'idtarifa');
    }
}
