<?php

namespace App\Modelos\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = 'canal';
    protected $primaryKey = 'idcanal';
    public $timestamps = false;

    public function toma()
    {
        return $this->hasMany('App\Modelos\Ubicacion\Toma', 'idcanal');
    }
}
