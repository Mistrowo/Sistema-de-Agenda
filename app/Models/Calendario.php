<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    public $timestamps = false;
    protected $table = 'calendario'; 

    protected $fillable = [
        'NOTA_VENTA', 'DESCRIPCION', 'CLIENTE', 'DETALLE', 'EJECUTIVO', 'FECHA_FABRIL', 'FECHA_INTALACION',
    ];

    protected $dates = ['FECHA_FABRIL', 'FECHA_INTALACION'];
}
