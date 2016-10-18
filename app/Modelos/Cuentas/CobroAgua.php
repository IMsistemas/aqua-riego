<?php

namespace App\Modelos\Cuentas;

use Illuminate\Database\Eloquent\Model;

class CobroAgua extends Model
{
    protected $table = 'cobroagua';
    protected $primaryKey = 'idcuenta';
    public $timestamps = false;

    public function terreno()
    {
        return $this->belongsTo('App\Modelos\Terreno\Terreno', 'idterreno');
    }

    public function descuento()
    {
        return $this->belongsTo('App\Modelos\Cuentas\Descuento', 'iddescuento');
    }

    public function recargo()
    {
        return $this->belongsTo('App\Modelos\Cuentas\Recargo', 'idrecargo');
    }
}
