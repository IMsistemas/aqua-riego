<?php
 
namespace App\Modelos\Tomas;

use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    protected $table = "derivacion";
    protected $primarykey = "idderivacion";
    public $timestamps = false;
    public $incrementing = false;

    public function toma(){
    	return $this->belongsTo('App\Modelos\Tomas\Toma','idtoma');
    }

}
 