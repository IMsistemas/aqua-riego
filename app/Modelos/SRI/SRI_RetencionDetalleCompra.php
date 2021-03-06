<?php

namespace App\Modelos\SRI;

use Illuminate\Database\Eloquent\Model;

class SRI_RetencionDetalleCompra extends Model
{
    protected $table = 'sri_retenciondetallecompra';
    protected $primaryKey = 'idretenciondetallecompra';
    public $timestamps = false;

    public function sri_detalleimpuestoretencion()
    {
        return $this->belongsTo('App\Modelos\SRI\SRI_DetalleImpuestoRetencion','iddetalleimpuestoretencion');
    }
}
