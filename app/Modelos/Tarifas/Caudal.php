<?php

namespace App\Modelos\Tarifas;

use Illuminate\Database\Eloquent\Model;

class Caudal extends Model
{
    protected $table = 'caudal';
    protected $primaryKey = 'idcaudal';
    public $timestamps = false;
}
