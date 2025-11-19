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
    protected $table = 'NotaVta_Actualiza'; // NOMBRE CORRECTO
    
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
}