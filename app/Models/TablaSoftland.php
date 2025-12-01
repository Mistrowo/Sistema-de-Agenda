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
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
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
     *
     * @var array
     */
    protected $casts = [
        'nv_femision' => 'date',
        'nv_fentrega' => 'date',
    ];
    
    /**
     */
    public function nvgestion()
    {
        return $this->hasOne(Nvgestion::class, 'c_nventa', 'nv_folio');
    }
    
    
    
    public function getFechaEntregaPrioritariaAttribute()
    {
        if ($this->nvgestion && $this->nvgestion->c_fecha_modificada) {
            return $this->nvgestion->c_fecha_modificada;
        }
        
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