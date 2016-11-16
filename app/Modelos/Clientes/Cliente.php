<?php 

namespace App\Modelos\Clientes;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'codigocliente';
    public $timestamps = false;

    public function solicitud()
    {
    	return $this->hasMany('App\Modelos\Solicitud\Solicitud','codigocliente');
    }

    public function terreno()
    {
        return $this->hasMany('App\Modelos\Terreno\Terreno', 'codigocliente');
    }

}
 