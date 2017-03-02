<?php
 
namespace App\Modelos\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Cont_Kardex extends Model
{
    protected $table = "cont_kardex";

    protected $primaryKey = "idtransaccion";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idtransaccion',
        'idproducto_bodega',
        'fecharegistro',
        'cantidad',
        'costounitario',
        'costototal',
        'tipoentradasalida',
        'estadoanulado',
        'descripcion'
    ];
    

   
}
