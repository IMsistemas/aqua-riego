<?php
 
namespace App\Modelos\Tomas;

use Illuminate\Database\Eloquent\Model;

class Toma extends Model
{
    protected $table = "toma";
    protected $primaryKey = "idtoma";
    public $timestamps = false;
    public $incrementing = false;

    public function canal(){
    	return $this->belongsTo('App\Modelos\Tomas\Canal','idcanal');
    }

    public function derivacion(){
    	return $this->hasMany('App\Modelos\Tomas\Derivacion','idtoma');
    }
}
