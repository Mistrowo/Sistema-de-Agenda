<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\CalendarioDef;
use Illuminate\Http\Request;
use App\Services\CalendarioService;

/**
 * Class CalendarioDefController
 * @package App\Http\Controllers
 */
class CalendarioDefController extends Controller
{
    protected $calendarioService;

    public function __construct(CalendarioService $calendarioService)
    {
        $this->calendarioService = $calendarioService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $calendarioDef = new CalendarioDef();
        return view('calendario-def.create', compact('calendarioDef'));
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function show($id)
    {
        $calendarioDef = CalendarioDef::find($id);

        return view('calendario-def.show', compact('calendarioDef'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $calendarioDef = CalendarioDef::find($id);

        return view('calendario-def.edit', compact('calendarioDef'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalendarioDef $calendarioDef)
    {
        request()->validate([
            'estado_despacho' => 'required',
        ]);

        $this->calendarioService->actualizarEstadoDespacho(
            $calendarioDef,
            $request->estado_despacho,
            $request->comentario
        );

        return redirect()->route('calendario')
            ->with('success', 'CalendarioDef actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $calendarioDef = CalendarioDef::findOrFail($id);
        $calendarioDef->delete();

        return redirect()->route('calendario')->with('success', 'Registro eliminado con éxito');
    }

    /**
     * Mostrar calendario principal con filtros
     */
    public function calendario(Request $request)
    {
        try {
            $notasVentaSoftland = $this->calendarioService->obtenerNotasVentaSoftland($request);
            $notasConAgenda = $this->calendarioService->obtenerEstadosAgenda($notasVentaSoftland);
            
        } catch (\Exception $e) {
            Log::warning('Error en calendario: ' . $e->getMessage());
            $notasVentaSoftland = collect([]);
            $notasConAgenda = [];
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
            $resultado = $this->calendarioService->actualizarFechasDesdeNvgestion($request);
            
            return response()->json([
                'success' => true,
                'actualizados' => $resultado['actualizados'],
                'sin_cambios' => $resultado['sin_cambios'],
                'total' => $resultado['total'],
                'message' => "Se actualizaron {$resultado['actualizados']} fechas desde Nvgestion"
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar fechas: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar fechas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calendario filtrado por instalador (con rango de fechas)
     */
    public function calendario3(Request $request)
    {
        $nombreInstalador = session('usuario') ? session('usuario')->NOMBRE : null;
        $calendario2 = $this->calendarioService->obtenerCalendarioPorInstalador($nombreInstalador, $request);

        return view('calendario-def.listado2', compact('calendario2'));
    }

    /**
     * Actualizar proyecto vía AJAX
     */
    public function actualizarProyecto(Request $request, $id)
    {
        try {
            $this->calendarioService->actualizarProyecto($id, $request->proyecto);
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar proyecto: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Calendario para Khemnova con porcentajes de despacho
     */
    public function calendario4(Request $request)
    {
        $calendario = $this->calendarioService->obtenerCalendarioConDespacho($request);
        return view('calendario-def.listado-khem', compact('calendario'));
    }

    /**
     * Agenda individual del instalador
     */
    public function calendario2()
    {
        $nombreInstalador = session('usuario') ? session('usuario')->NOMBRE : null;
        $calendario1 = $this->calendarioService->obtenerCalendarioPorInstalador($nombreInstalador);

        return view('calendario-def.agendaindi', compact('calendario1'));
    }
}