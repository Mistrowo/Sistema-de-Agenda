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

    /**
     * ✅ Relación con TablaSoftland para obtener datos del cliente
     */
    public function notaVentaSoftland()
    {
        return $this->belongsTo(\App\Models\TablaSoftland::class, 'nota_venta', 'nv_folio');
    }

    /**
     * ✅ Accessor para obtener el cliente directamente
     */
    public function getClienteAttribute()
    {
        return $this->notaVentaSoftland?->nv_cliente ?? 'Sin cliente';
    }
}