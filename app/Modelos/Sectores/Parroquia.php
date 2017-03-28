<?php

namespace App\Modelos\Sectores;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    protected $table = 'parroquia';
    protected $primaryKey = 'idparroquia';
    public $timestamps = false;

    public function Emp_Canton()
    {
        return $this->belongsTo('App\Modelos\Empresa\Emp_Canton','idcanton');
    }
    //
}
