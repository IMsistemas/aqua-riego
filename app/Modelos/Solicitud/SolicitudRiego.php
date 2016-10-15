<?php

namespace App\Modelos\Solicitud;

use Illuminate\Database\Eloquent\Model;

class SolicitudRiego extends Model
{
    protected $table = 'solicitudriego';
    protected $primaryKey = 'idsolicitudriego';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Clientes\Cliente', 'codigocliente');
    }

}
