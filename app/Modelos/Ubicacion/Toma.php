<?php

namespace App\Modelos\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Toma extends Model
{
    protected $table = 'toma';
    protected $primaryKey = 'idtoma';
    public $timestamps = false;

    public function canal()
    {
        return $this->belongsTo('App\Modelos\Ubicacion\Canal', 'idcanal');
    }

    public function derivacion()
    {
        return $this->hasMany('App\Modelos\Ubicacion\Derivacion', 'idtoma');
    }
}
