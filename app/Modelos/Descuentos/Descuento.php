<?php 

namespace App\Modelos\Descuentos;

use Illuminate\Database\Eloquent\Model;


class Descuento extends Model
{
    protected $table = "descuento";
    protected $primaryKey = "iddescuento";
    public $timestamps = false;
    public $incrementing = false;
    /*public function cobroagua(){
        return $this->belongsTo('App\Modelos\Cuentas\Cobroagua','idprovincia');
    }*/

}
 