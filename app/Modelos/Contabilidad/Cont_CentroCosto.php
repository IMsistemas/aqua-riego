<?php

namespace App\Modelos\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class Cont_CentroCosto extends Model
{
    protected $table = 'cont_centrocosto';
    protected $primaryKey = 'idcentrocosto';
    public $timestamps = false;
}
