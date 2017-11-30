<?php

namespace App\Modelos\Solicitud;

use Illuminate\Database\Eloquent\Model;

class SolicitudEliminacion extends Model
{
    protected $table = 'solicitudeliminacion';
    protected $primaryKey = 'idsolicitudeliminacion';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Clientes\Cliente', 'idcliente');
    }

    public function terreno()
    {
        return $this->belongsTo('App\Modelos\Terreno\Terreno', 'idterreno');
    }

    public function solicitud()
    {
        return $this->belongsTo('App\Modelos\Solicitud\Solicitud', 'idsolicitud');
    }
}
