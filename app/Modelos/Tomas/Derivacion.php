<?php
 
namespace App\Modelos\Tomas;

use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    protected $table = "derivacion";
    protected $primaryKey = "idderivacion";
    public $timestamps = false;

    public function canal(){
        return $this->belongsTo('App\Modelos\Tomas\Canal','idcanal');
    }

}
 