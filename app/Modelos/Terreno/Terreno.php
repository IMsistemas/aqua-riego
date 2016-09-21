<?php

namespace App\Modelos\Terreno;

use Illuminate\Database\Eloquent\Model;

class Terreno extends Model
{
    protected $table = 'terreno';
    protected $primaryKey = 'idterreno';
    public $timestamps = false;

    public function cultivo()
    {
        return $this->belongsTo('App\Modelos\Terreno\Cultivo', 'idcultivo');
    }
}
