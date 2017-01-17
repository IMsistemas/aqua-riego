<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    public $timestamps = false;

}
