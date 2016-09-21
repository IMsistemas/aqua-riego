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

}
