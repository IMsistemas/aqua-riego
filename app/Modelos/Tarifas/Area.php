<?php

namespace App\Modelos\Tarifas;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'idarea';
    public $timestamps = false;

    public function tarifa()
    {
        return $this->belongsTo('App\Modelos\Tarifas\Tarifa', 'idtarifa');
    }

}
