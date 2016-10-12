<?php
 
namespace App\Modelos\Tomas;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = "canal";
    protected $primaryKey = "idcanal";
    public $timestamps = false;

    public function calle(){
        return $this->belongsTo('App\Modelos\Tomas\Calle','idcalle');
    }

    public function derivacion(){
        return $this->hasMany('App\Modelos\Tomas\Derivacion','idcanal');
    }
}
