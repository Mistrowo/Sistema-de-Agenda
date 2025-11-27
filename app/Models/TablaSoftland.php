<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablaSoftland extends Model
{
    /**
     *
     * @var string
     */
    protected $connection = 'sqlsrv_soft';
    
    /**
     *
     * @var string
     */
    protected $table = 'NotaVta_Actualiza';
    
    /**
     *
     * @var string
     */
    protected $primaryKey = 'nv_id';
    
    /**
     * Indica si el modelo debe usar timestamps.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nv_id',
        'nv_folio',
        'nv_descripcion',
        'nv_cliente',
        'nv_vend',
        'nv_estado',
        'nv_femision',
        'nv_fentrega',
    ];
    
    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'nv_femision' => 'date',
        'nv_fentrega' => 'date',
    ];
    
    /**
     * Relación con Nvgestion
     */
    public function nvgestion()
    {
        return $this->hasOne(Nvgestion::class, 'c_nventa', 'nv_folio');
    }
    
    /**
     * Accessor para obtener la fecha de entrega prioritaria
     * Primero intenta traer c_fecha_modificada de Nvgestion
     * Si no existe o es null, devuelve nv_fentrega
     */
    public function getFechaEntregaPrioritariaAttribute()
    {
        // Intentar obtener la fecha modificada de Nvgestion
        if ($this->nvgestion && $this->nvgestion->c_fecha_modificada) {
            return $this->nvgestion->c_fecha_modificada;
        }
        
        // Si no existe, devolver la fecha de entrega de Softland
        return $this->nv_fentrega;
    }
    
    /**
     * Método para verificar si tiene fecha modificada en Nvgestion
     */
    public function tieneFechaModificada()
    {
        return $this->nvgestion && $this->nvgestion->c_fecha_modificada !== null;
    }
}