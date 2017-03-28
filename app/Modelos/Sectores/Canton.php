<?php

namespace App\Modelos\Sectores;

use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    protected $table = 'canton';
    protected $primaryKey = 'idcanton';
    public $timestamps = false;

    public function Provincia()
    {
        return $this->belongsTo('App\Modelos\Empresa\Provincia','idprovincia');
    }

    //
}
