<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\CalendarioDef;
use Illuminate\Http\Request;
use App\Models\AgendaDef;
use Carbon\Carbon;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\TablaSoftland;
use App\Models\Nvgestion;


/**
 * Class CalendarioDefController
 * @package App\Http\Controllers
 */
class CalendarioDefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $calendarioDef = new CalendarioDef();
        return view('calendario-def.create', compact('calendarioDef'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(CalendarioDef::$rules);

        $calendarioDef = CalendarioDef::create($request->all());

        return redirect()->route('calendario-defs.index')
            ->with('success', 'CalendarioDef created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $calendarioDef = CalendarioDef::find($id);

        return view('calendario-def.show', compact('calendarioDef'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calendarioDef = CalendarioDef::find($id);

        return view('calendario-def.edit', compact('calendarioDef'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  CalendarioDef $calendarioDef
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarioDef $calendarioDef)
    {
        request()->validate([
            'estado_despacho' => 'required',
        ]);
    
        $calendarioDef->estado_despacho = $request->estado_despacho;
    
        // Solo actualiza el comentario si estado_despacho no es 'Finalizado'
        // Y si se proporciona un comentario en el formulario
        if ($request->estado_despacho != 'Finalizado' && $request->has('comentario')) {
            $calendarioDef->comentario = $request->comentario;
        }
    
        $calendarioDef->save();
    
        return redirect()->route('calendario')
            ->with('success', 'CalendarioDef actualizado exitosamente.');
    }
    
    
    

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $calendarioDef = CalendarioDef::findOrFail($id);
        $calendarioDef->delete();
    
        return redirect()->route('calendario')->with('success', 'Registro eliminado con éxito');
    }

    public function calendario(Request $request)
    {
        $notasVentaSoftland = collect();
        $notasConAgenda = [];
        
        try {
            // Query base con relación eager loading para Nvgestion
            $query = \App\Models\TablaSoftland::with('nvgestion')
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
            
            // FILTRO POR NOTA DE VENTA
            if ($request->filled('nota_venta')) {
                $query->where('nv_folio', 'LIKE', '%' . $request->nota_venta . '%');
            }
            
            // FILTRO POR TIPO DE FECHA
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
            
            // Ordenar y paginar
            $notasVentaSoftland = $query->orderBy('nv_femision', 'desc')
                                       ->paginate(50)
                                       ->appends($request->all()); // Mantener filtros en paginación
            
            Log::info('Registros cargados de Softland: ' . $notasVentaSoftland->total());
            
            // Obtener estados de agenda
            $todasLasAgendas = \App\Models\AgendaDef::all();
            
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
            
        } catch (\Exception $e) {
            Log::warning('No se pudo conectar a Softland: ' . $e->getMessage());
            
            $notasVentaSoftland = collect([]);
            
            session()->flash('warning', '⚠️ No se pudo conectar a Softland.');
        }

        return view('calendario-def.listado', compact('notasVentaSoftland', 'notasConAgenda'));
    }

    /**
     * Actualizar masivamente las fechas de entrega desde Nvgestion
     */
    public function actualizarFechasDesdeNvgestion(Request $request)
    {
        try {
            set_time_limit(300); // 5 minutos de timeout
            
            $actualizados = 0;
            $sinCambios = 0;
            
            // Obtener todas las notas que están en la vista actual
            $query = \App\Models\TablaSoftland::with('nvgestion');
            
            // Aplicar los mismos filtros que en calendario()
            if ($request->filled('nota_venta')) {
                $query->where('nv_folio', 'LIKE', '%' . $request->nota_venta . '%');
            }
            
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
            
            $notas = $query->get();
            
            foreach ($notas as $nota) {
                if ($nota->nvgestion && $nota->nvgestion->c_fecha_modificada) {
                    $actualizados++;
                } else {
                    $sinCambios++;
                }
            }
            
            Log::info("Actualización de fechas completada: {$actualizados} con fecha modificada, {$sinCambios} sin cambios");
            
            return response()->json([
                'success' => true,
                'actualizados' => $actualizados,
                'sin_cambios' => $sinCambios,
                'total' => $actualizados + $sinCambios,
                'message' => "Se actualizaron {$actualizados} fechas desde Nvgestion"
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar fechas: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar fechas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function calendario3(Request $request)
    {
        $nombreInstalador = session('usuario') ? session('usuario')->NOMBRE : null;
                        
        $query = CalendarioDef::query();
    
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            $query->whereHas('agendaDefs', function ($q) use ($request, $nombreInstalador) {
                $q->where('instalador', $nombreInstalador)
                  ->whereBetween('fecha_instalacion', [$request->fecha_inicio, $request->fecha_fin]);
            });
        } else {
            $query->whereHas('agendaDefs', function ($q) use ($nombreInstalador) {
                $q->where('instalador', $nombreInstalador);
            });
        }
    
        
        $calendario2 = $query->with(['agendaDefs' => function ($query) use ($nombreInstalador) {
            $query->where('instalador', $nombreInstalador);
        }])->get();
    
        $calendario2 = $calendario2->filter(function ($calendario) {
            return $calendario->agendaDefs->isNotEmpty(); 
        })->unique('nota_venta'); 
    
        return view('calendario-def.listado2', compact('calendario2'));
    }
    
    
    
    public function actualizarProyecto(Request $request, $id)
    {
        $calendarioDef = CalendarioDef::findOrFail($id);
        $calendarioDef->proyecto = $request->proyecto;
        $calendarioDef->save();
    
        return response()->json(['success' => true]);
    }
    




    public function calendario4(Request $request)
    {
        $query = CalendarioDef::with('agendaDefs');
    
        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $query->whereBetween('fecha_instalacion', [$request->fecha_desde, $request->fecha_hasta]);
        } else {
            return view('calendario-def.listado-khem', ['calendario' => collect()]);
        }
    
        $calendario = $query->get()->map(function ($item) {
            $item->calendarizado = $item->agendaDefs->contains(function ($agendaDef) {
                return !empty($agendaDef->instalador);
            });
    
            $productos = Producto::where('nota_venta', $item->nota_venta)
                                 ->where('cliente', $item->cliente)
                                 ->get();
    
            if ($productos->isNotEmpty()) {
                $cantidadTotalSolicitada = $productos->sum('cantidad_solicitada');
                $cantidadTotalDespachada = $productos->sum('cantidad_despachada');
    
                $porcentajeDespachado = ($cantidadTotalDespachada / $cantidadTotalSolicitada) * 100;
                $item->porcentajeDespachado = round($porcentajeDespachado);
            } else {
                $item->porcentajeDespachado = null;
            }
    
            return $item;
        });
        return view('calendario-def.listado-khem', compact('calendario'));
    }
    
    public function calendario2()
    {

       
    $nombreInstalador = session('usuario') ? session('usuario')->NOMBRE : null;
    $calendario1 = CalendarioDef::with('agendaDefs')
                    ->whereHas('agendaDefs', function ($query) use ($nombreInstalador) {
                        $query->where('instalador', $nombreInstalador);
                    })
                    ->get();

    return view('calendario-def.agendaindi', compact('calendario1'));



    
    }


    


   
    

}