<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CalendarioDef
 *
 * @property $id
 * @property $nota_venta
 * @property $descripcion
 * @property $cliente
 * @property $detalle
 * @property $ejecutivo
 * @property $fecha_fabril
 * @property $fecha_instalacion
 * @property $created_at
 * @property $updated_at
 *
 * @property AgendaDef[] $agendaDefs
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CalendarioDef extends Model
{
  protected $table = 'calendario_def';

    static $rules = [
		'nota_venta' => 'required',
		'descripcion' => 'required',
		'cliente' => 'required',
		'detalle' => 'required',
		'ejecutivo' => 'required',
		'fecha_fabril' => 'required',
		'fecha_instalacion' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
      'nota_venta', 'descripcion', 'cliente', 'detalle', 
      'ejecutivo', 'fecha_fabril', 'fecha_instalacion', 
      'estado_bloque', 'estado_despacho', 'comentario',
      'proyecto', 'id_proyecto','fecha_ingreso' ,'estado_nota_venta'
  ];
  
  

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendaDefs()
    {
        return $this->hasMany('App\Models\AgendaDef', 'nota_venta', 'nota_venta');
    }
    

}
