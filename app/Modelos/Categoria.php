<?php
 
namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "categoria";

    protected $primaryKey = "idcategoria";

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'idcategoria', 'nombrecategoria',
    ];

   
}
