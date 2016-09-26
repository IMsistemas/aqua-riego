<?php
 
namespace App\Modelos\Tomas;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = "canal";
    protected $primaryKey = "idcanal";
    public $timestamps = false;
    public $incrementing = false;
    public function toma(){
    	return $this->hasMany('App\Modelos\Tomas\Toma','idcanal');
    }
}
