<?php

namespace App\Modelos\Transportista;

use Illuminate\Database\Eloquent\Model;

class Transportista extends Model
{
    protected $table = "transportista";

    protected $primaryKey = "idtransportista";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idtransportista',
        'idpersona',
        'razonsocial',
        'placa',
        'estado',
        'fechaingreso',
        'telefonoprincipal',        
    ];
    public function persona(){
    	return $this->belongsTo('App\Modelos');
    }

    public function Cont_DocumentoGuiaRemision(){
        return $this->hasMany('App\Modelos\Contabilidad');
    }

}