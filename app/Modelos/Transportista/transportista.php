<?php

namespace App\Modelos\Transportista;

use Illuminate\Database\Eloquent\Model;

class transportista extends Model
{
    protected $table = "transportista";

    protected $primaryKey = "transportista";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idtransportista',
        'idpersona',
        'razonsocial',
        'placa',
        'estado',        
    ];
    public function persona(){
    	return $this->belongsTo('App\Modelos');
    }
}