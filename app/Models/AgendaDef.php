<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaDef extends Model
{
    protected $table = 'agenda_def';
    
    protected $fillable = [
        'nota_venta',
        'caja_titulo',
        'instalador',
        'bloque',
        'observacion_bloque',
        'fecha_agenda',
        'fecha_entrega',
        'estado',
        'nota_resumida',
        'transportista',
        'nota_resumida2',
        'fecha_instalacion2'
    ];

    
}