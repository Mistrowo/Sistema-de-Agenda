<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'sr_visor';
    protected $table = 'productos';
    protected $fillable = [
        'nota_venta',
        'codigo_producto',
        'descripcion_producto',
        'fecha_despacho',
        'cliente',
        'cantidad_solicitada',
        'cantidad_despachada',
        'bloque',
        'bodega',
    ];
}
