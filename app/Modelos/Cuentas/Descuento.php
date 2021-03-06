<?php

namespace App\Modelos\Cuentas;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuento';
    protected $primaryKey = 'iddescuento';
    public $timestamps = false;

    public function cobroagua(){
        return $this->hasMany('App\Modelos\Cuentas\CobroAgua','iddescuento');
    }

}
