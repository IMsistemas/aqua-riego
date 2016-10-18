<?php

namespace App\Modelos\Cuentas;

use Illuminate\Database\Eloquent\Model;

class Recargo extends Model
{
    protected $table = 'recargo';
    protected $primaryKey = 'idrecargo';
    public $timestamps = false;

    public function cobroagua(){
        return $this->hasMany('App\Modelos\Cuentas\CobroAgua','idrecargo');
    }
}
