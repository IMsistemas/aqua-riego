<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'idtransportista',
        'idpersona',
        'razonsocial',
        'placa',
        'estado',        
    ];
    public function transportista(){
    	return $this->hasMany('App\Modelos\Transportista');
    }
    public function cliente(){
    	return $this->hasMany('App\Modelos\Clientes');
    }

}
