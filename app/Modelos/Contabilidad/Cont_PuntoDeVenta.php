<?php
 
namespace App\Modelos\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Cont_PuntoDeVenta extends Model
{
    protected $table = "cont_puntoventa";

    protected $primaryKey = "idpuntoventa";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idpuntoventa',
        'idestablecimiento',
        'idempleado',
        'codigoptoemision'
    ];

    public function sri_establecimiento(){
        return $this->belongsTo('App\Modelos\SRI\SRI_Establecimiento',"idestablecimiento");
    }
    
    public function empleado(){
    	return $this->belongsTo('App\Modelos\Empleado');
    }

   
}
