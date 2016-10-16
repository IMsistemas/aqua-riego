<?php

namespace App\Modelos\Clientes;

use Illuminate\Database\Eloquent\Model;

class ClienteArriendo extends Model
{
    protected $table = 'clientearriendo';
    protected $primaryKey = 'idarriendo';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Clientes\Cliente', 'codigocliente');
    }

    public function terreno()
    {
        return $this->belongsTo('App\Modelos\Terreno\Terreno', 'idterreno');
    }
}
