<?php

namespace App\Services;

use App\Models\TablaSoftland;
use App\Models\AgendaDef;
use App\Models\CalendarioDef;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CalendarioService
{
    /**
     * Obtener notas de venta de Softland con filtros aplicados
     */
    public function obtenerNotasVentaSoftland(Request $request)
    {
        try {
            $query = TablaSoftland::with('nvgestion')
                ->select([
                    'nv_id',
                    'nv_folio',
                    'nv_descripcion',
                    'nv_cliente',
                    'nv_vend',
                    'nv_estado',
                    'nv_femision',
                    'nv_fentrega'
                ]);
            
            // Aplicar filtros
            $query = $this->aplicarFiltros($query, $request);
            
            // Ordenar y paginar
            $notasVentaSoftland = $query->orderBy('nv_femision', 'desc')
                                       ->paginate(50)
                                       ->appends($request->all());
            
            Log::info('Registros cargados de Softland: ' . $notasVentaSoftland->total());
            
            return $notasVentaSoftland;
            
        } catch (\Exception $e) {
            Log::warning('No se pudo conectar a Softland: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Aplicar filtros de búsqueda y fecha
     */
    private function aplicarFiltros($query, Request $request)
    {
        // Filtro por nota de venta
        if ($request->filled('nota_venta')) {
            $query->where('nv_folio', 'LIKE', '%' . $request->nota_venta . '%');
        }
        
        // Filtro por fechas
        $tipoFecha = $request->input('tipo_fecha', 'emision');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        
        if ($fechaDesde || $fechaHasta) {
            $campoFecha = ($tipoFecha === 'entrega') ? 'nv_fentrega' : 'nv_femision';
            
            if ($fechaDesde && $fechaHasta) {
                $query->whereBetween($campoFecha, [$fechaDesde, $fechaHasta]);
            } elseif ($fechaDesde) {
                $query->where($campoFecha, '>=', $fechaDesde);
            } elseif ($fechaHasta) {
                $query->where($campoFecha, '<=', $fechaHasta);
            }
        }
        
        return $query;
    }

    /**
     * Obtener estados de agenda para las notas de venta
     */
    public function obtenerEstadosAgenda($notasVentaSoftland)
    {
        $notasConAgenda = [];
        $todasLasAgendas = AgendaDef::all();
        
        foreach ($notasVentaSoftland as $nota) {
            $folio = $nota->nv_folio;
            
            $agendasDeEstaNota = $todasLasAgendas->filter(function($agenda) use ($folio) {
                return $agenda->nota_venta == $folio;
            });
            
            if ($agendasDeEstaNota->isNotEmpty()) {
                $notasConAgenda[$folio] = [
                    'total' => $agendasDeEstaNota->count(),
                    'calendarizado' => $agendasDeEstaNota->where('estado', 'Calendarizado')->count(),
                    'en_espera' => $agendasDeEstaNota->where('estado', 'En espera')->count(),
                    'post_venta' => $agendasDeEstaNota->where('estado', 'Post-Venta')->count(),
                ];
            }
        }
        
        return $notasConAgenda;
    }

    /**
     * Actualizar fechas masivamente desde Nvgestion
     */
    public function actualizarFechasDesdeNvgestion(Request $request)
    {
        set_time_limit(300); // 5 minutos
        
        $actualizados = 0;
        $sinCambios = 0;
        
        // Obtener notas con filtros aplicados
        $query = TablaSoftland::with('nvgestion');
        $query = $this->aplicarFiltros($query, $request);
        $notas = $query->get();
        
        foreach ($notas as $nota) {
            if ($nota->nvgestion && $nota->nvgestion->c_fecha_modificada) {
                $actualizados++;
            } else {
                $sinCambios++;
            }
        }
        
        Log::info("Actualización de fechas completada: {$actualizados} con fecha modificada, {$sinCambios} sin cambios");
        
        return [
            'actualizados' => $actualizados,
            'sin_cambios' => $sinCambios,
            'total' => $actualizados + $sinCambios
        ];
    }

    /**
     * Obtener calendario filtrado por instalador
     */
    public function obtenerCalendarioPorInstalador($nombreInstalador, Request $request = null)
    {
        $query = CalendarioDef::query();
        
        if ($request && $request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $query->whereHas('agendaDefs', function ($q) use ($request, $nombreInstalador) {
                $q->where('instalador', $nombreInstalador)
                  ->whereBetween('fecha_instalacion', [$request->fecha_inicio, $request->fecha_fin]);
            });
        } else {
            $query->whereHas('agendaDefs', function ($q) use ($nombreInstalador) {
                $q->where('instalador', $nombreInstalador);
            });
        }
        
        $calendario = $query->with(['agendaDefs' => function ($query) use ($nombreInstalador) {
            $query->where('instalador', $nombreInstalador);
        }])->get();
        
        // Filtrar solo los que tienen agendas y eliminar duplicados
        return $calendario->filter(function ($calendario) {
            return $calendario->agendaDefs->isNotEmpty(); 
        })->unique('nota_venta');
    }

    /**
     * Obtener calendario con porcentajes de despacho (Khemnova)
     */
    public function obtenerCalendarioConDespacho(Request $request)
    {
        if (!$request->filled('fecha_desde') || !$request->filled('fecha_hasta')) {
            return collect();
        }

        $query = CalendarioDef::with('agendaDefs')
            ->whereBetween('fecha_instalacion', [$request->fecha_desde, $request->fecha_hasta]);
        
        $calendario = $query->get()->map(function ($item) {
            $item->calendarizado = $item->agendaDefs->contains(function ($agendaDef) {
                return !empty($agendaDef->instalador);
            });
            
            // Calcular porcentaje de despacho
            $item->porcentajeDespachado = $this->calcularPorcentajeDespacho(
                $item->nota_venta, 
                $item->cliente
            );
            
            return $item;
        });
        
        return $calendario;
    }

    /**
     * Calcular porcentaje de despacho para una nota de venta
     */
    private function calcularPorcentajeDespacho($notaVenta, $cliente)
    {
        $productos = Producto::where('nota_venta', $notaVenta)
                             ->where('cliente', $cliente)
                             ->get();
        
        if ($productos->isEmpty()) {
            return null;
        }
        
        $cantidadTotalSolicitada = $productos->sum('cantidad_solicitada');
        $cantidadTotalDespachada = $productos->sum('cantidad_despachada');
        
        if ($cantidadTotalSolicitada == 0) {
            return 0;
        }
        
        return round(($cantidadTotalDespachada / $cantidadTotalSolicitada) * 100);
    }

    /**
     * Actualizar proyecto de un calendario
     */
    public function actualizarProyecto($id, $proyecto)
    {
        $calendarioDef = CalendarioDef::findOrFail($id);
        $calendarioDef->proyecto = $proyecto;
        $calendarioDef->save();
        
        return $calendarioDef;
    }

    /**
     * Actualizar estado de despacho
     */
    public function actualizarEstadoDespacho(CalendarioDef $calendarioDef, $estadoDespacho, $comentario = null)
    {
        $calendarioDef->estado_despacho = $estadoDespacho;
        
        if ($estadoDespacho != 'Finalizado' && $comentario) {
            $calendarioDef->comentario = $comentario;
        }
        
        $calendarioDef->save();
        
        return $calendarioDef;
    }
}