<?php

namespace App\Modelos\Tarifas;

use Illuminate\Database\Eloquent\Model;

class Caudal extends Model
{
    protected $table = 'caudal';
    protected $primaryKey = 'idcaudal';
    public $timestamps = false;

    public function tarifa()
    {
        return $this->belongsTo('App\Modelos\Tarifas\Tarifa', 'idtarifa');
    }

}
