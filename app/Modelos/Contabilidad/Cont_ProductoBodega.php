<?php
 
namespace App\Modelos\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Cont_ProductoBodega extends Model
{
    protected $table = "cont_producto_bodega";

    protected $primaryKey = "idproducto_bodega";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idproducto_bodega',
        'idcatalogitem',
        'idbodega'
    ];
    

   
}
