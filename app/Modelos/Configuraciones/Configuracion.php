<?php
 
namespace App\Modelos\Configuraciones;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}