<?php 

namespace App\Modelos\Clientes;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'idcliente';
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Modelos\Persona','idpersona');
    }

    public function solicitud()
    {
    	return $this->hasMany('App\Modelos\Solicitud\Solicitud','idcliente');
    }

    public function terreno()
    {
        return $this->hasMany('App\Modelos\Terreno\Terreno', 'idcliente');
    }

}
 