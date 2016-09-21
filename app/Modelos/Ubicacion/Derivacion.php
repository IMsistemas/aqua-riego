<?php

namespace App\Modelos\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    protected $table = 'derivacion';
    protected $primaryKey = 'idderivacion';
    public $timestamps = false;

    public function toma()
    {
        return $this->belongsTo('App\Modelos\Ubicacion\Toma', 'idtoma');
    }

    public function terreno()
    {
        return $this->hasMany('App\Modelos\Terreno\Terreno', 'idderivacion');
    }
}
