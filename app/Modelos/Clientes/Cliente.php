<?php 

namespace App\Modelos\Clientes;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $table = "cliente";
    protected $primaryKey = "codigocliente";
    public $timestamps = false;

    public function solicitud(){
    	return $this->hasMany('App\Modelos\Solicitud','idsolicitud');
    }

}
 