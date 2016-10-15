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

    public function tarifa()
    {
        return $this->belongsTo('App\Modelos\Tarifas\Tarifa', 'idtarifa');
    }

    public function derivacion()
    {
        return $this->belongsTo('App\Modelos\Tomas\Derivacion', 'idderivacion');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Clientes\Cliente', 'codigocliente');
    }

    public function barrio()
    {
        return $this->belongsTo('App\Modelos\Sectores\Barrio', 'idbarrio');
    }
}
