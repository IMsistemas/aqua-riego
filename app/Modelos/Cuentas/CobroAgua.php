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
}
