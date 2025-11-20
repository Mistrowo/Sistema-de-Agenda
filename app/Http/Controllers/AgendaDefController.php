<?php

namespace App\Http\Controllers;

use App\Models\AgendaDef;
use App\Models\CalendarioDef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

/**
 * Class AgendaDefController
 * @package App\Http\Controllers
 */
class AgendaDefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agendaDefs = AgendaDef::paginate(); // O cualquier otra lógica para obtener los datos
    
        return view('listado', compact('agendaDefs'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agendaDef = new AgendaDef();
        return view('listado', compact('agendaDef'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    // Log para debugging
    Log::info('=== STORE INICIO ===');
    Log::info('Datos recibidos RAW:', $request->all());
    
    try {
        $validatedData = $request->validate([
            'nota_venta' => 'required',
            'instalador' => 'required',
            'bloque' => 'required',
            'observacion_bloque' => 'nullable|string',
            'estado' => 'required',
            'fecha_entrega' => 'nullable|date',
            'transportista' => 'nullable',
            'nota_resumida' => 'nullable|string',
            'nota_resumida2' => 'nullable|string',
            'fecha_instalacion2' => 'required|date',
        ]);
        
        Log::info('Datos validados:', $validatedData);

        // Procesar el bloque - puede venir en diferentes formatos
        $bloqueOriginal = $validatedData['bloque'];
        Log::info('Bloque original:', ['bloque' => $bloqueOriginal]);
        
        // Si viene como "BLOQUE A-1 (8:00-10:00)", extraer solo "A-1"
        if (strpos($bloqueOriginal, 'BLOQUE') !== false) {
            preg_match('/BLOQUE\s+([A-Z]-\d+)/', $bloqueOriginal, $matches);
            $bloqueFormateado = $matches[1] ?? $bloqueOriginal;
        } else {
            // Si ya viene como "A-1" o similar
            $bloqueFormateado = $bloqueOriginal;
        }
        
        $validatedData['bloque'] = $bloqueFormateado;
        Log::info('Bloque formateado:', ['bloque' => $bloqueFormateado]);
    
        // Crear o actualizar el registro
        $agendaDef = AgendaDef::updateOrCreate(
            [
                'nota_venta' => $validatedData['nota_venta'],
                'instalador' => $validatedData['instalador'],
                'bloque' => $bloqueFormateado,
                'fecha_instalacion2' => $validatedData['fecha_instalacion2']
            ],
            [
                'observacion_bloque' => $validatedData['observacion_bloque'] ?? null,
                'estado' => $validatedData['estado'],
                'fecha_entrega' => $validatedData['fecha_entrega'] ?? null,
                'transportista' => $validatedData['transportista'],
                'nota_resumida' => $validatedData['nota_resumida'] ?? null,
                'nota_resumida2' => $validatedData['nota_resumida2'] ?? null,
            ]
        );

        Log::info('Registro guardado exitosamente:', ['id' => $agendaDef->id]);
        
        return response()->json([
            'success' => true,
            'message' => 'Operación realizada exitosamente.',
            'data' => $agendaDef
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Error de validación:', [
            'errors' => $e->errors(),
            'message' => $e->getMessage()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Error en store:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al guardar: ' . $e->getMessage()
        ], 500);
    }
}

    public function store3(Request $request)
    {
        $validatedData = $request->validate([
            'nota_venta' => 'required',
            'instalador' => 'required',
            'bloque' => 'required',
            'observacion_bloque' => 'nullable',
            'estado' => 'required',
            'fecha_entrega' => 'nullable',
            'transportista' => 'required',
            'nota_resumida' => 'required',
            'nota_resumida2' => 'required',
            'fecha_instalacion2' => 'required',
        ]);
    
        $agendaDef = new AgendaDef();
        $agendaDef->fill($validatedData);
        $agendaDef->save();
    
        return response()->json(['success' => 'Operación realizada exitosamente.']);
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agendaDef = AgendaDef::find($id);

        return view('agenda-def.show', compact('agendaDef'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agendaDef = AgendaDef::find($id);

        return view('agenda-def.edit', compact('agendaDef'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  AgendaDef $agendaDef
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgendaDef $agendaDef)
    {
        request()->validate(AgendaDef::$rules);

        $agendaDef->update($request->all());

        return redirect()->route('agenda-defs.index')
            ->with('success', 'AgendaDef updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $agendaDef = AgendaDef::find($id)->delete();

        return redirect()->route('agenda-defs.index')
            ->with('success', 'AgendaDef deleted successfully');
    }
    public function destroy1(Request $request)
    {
        $notaVenta = $request->input('nota_venta');
        $instalador = $request->input('instalador');
        $bloque = $request->input('bloque');
    
        $agendaDef = AgendaDef::where('nota_venta', $notaVenta)
                              ->where('instalador', $instalador)
                              ->where('bloque', $bloque)
                              ->first();
    
        if ($agendaDef) {
            $agendaDef->delete();
            return response()->json(['success' => 'Registro eliminado con éxito']);
        } else {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }

    public function update1(Request $request)
{
    Log::info('Datos recibidos:', $request->all());
    $notaVenta = $request->input('nota_venta');
    $instaladorAntiguo = $request->input('instalador_antiguo');
    $instaladorNuevo = $request->input('instalador_nuevo');
    $bloqueAntiguo = $request->input('bloque_antiguo');
    $bloqueNuevo = $request->input('bloque_nuevo');
    $fechaInstalacionAntigua = $request->input('fecha_instalacion_antigua');
    $fechaInstalacionNueva = $request->input('fecha_instalacion_nueva');

    $agendaDef = AgendaDef::where('nota_venta', $notaVenta)
                          ->where('instalador', $instaladorAntiguo)
                          ->where('bloque', $bloqueAntiguo)
                          ->where('fecha_instalacion2', $fechaInstalacionAntigua)
                          ->first();

    if ($agendaDef) {
        $campos = ['fecha_entrega', 'cliente', 'nota_resumida', 'observacion_bloque', 'estado', 'nota_resumida2'];

        $datosActualizados = [];
        foreach ($campos as $campo) {
            if ($request->has($campo) && $request->input($campo) != '') {
                $datosActualizados[$campo] = $request->input($campo);
            }
        }

        if ($request->has('transportista') && $request->input('transportista') != '') {
            $datosActualizados['transportista'] = $request->input('transportista');
        }

        if ($fechaInstalacionNueva != '') {
            $datosActualizados['fecha_instalacion2'] = $fechaInstalacionNueva;
        }

        // Actualizar el instalador con el nuevo valor
        if ($instaladorNuevo != '') {
            $datosActualizados['instalador'] = $instaladorNuevo;
        }

        if ($request->has('nota_resumida') && $request->input('nota_resumida') != '') {
            $datosActualizados['nota_resumida'] = $request->input('nota_resumida');
        }
        

        // Actualizar el bloque con el nuevo valor
        if ($bloqueNuevo != '') {
            $datosActualizados['bloque'] = $bloqueNuevo;
        }

        if (!empty($datosActualizados)) {
            $agendaDef->update($datosActualizados);
            return response()->json(['success' => 'Registro actualizado con éxito']);
        } else {
            return response()->json(['error' => 'No hay datos para actualizar'], 400);
        }
    } else {
        return response()->json(['error' => 'Registro no encontrado'], 404);
    }
}

public function update2(Request $request)
{
    Log::info('Datos recibidos:', $request->all());
    $notaVenta = $request->input('nota_venta');
    $instaladorAntiguo = $request->input('instalador_antiguo');
    $instaladorNuevo = $request->input('instalador_nuevo');
    $bloqueAntiguo = $request->input('bloque_antiguo');
    $bloqueNuevo = $request->input('bloque_nuevo');
    $fechaInstalacionAntigua = $request->input('fecha_instalacion_antigua');
    $fechaInstalacionNueva = $request->input('fecha_instalacion_nueva');

    $agendaDef = AgendaDef::where('nota_venta', $notaVenta)
                          ->where('instalador', $instaladorAntiguo)
                          ->where('bloque', $bloqueAntiguo)
                          ->where('fecha_instalacion2', $fechaInstalacionAntigua)
                          ->first();

    if ($agendaDef) {
        $campos = ['fecha_entrega', 'cliente', 'nota_resumida', 'observacion_bloque', 'estado', 'nota_resumida2'];

        $datosActualizados = [];
        foreach ($campos as $campo) {
            if ($request->has($campo) && $request->input($campo) != '') {
                $datosActualizados[$campo] = $request->input($campo);
            }
        }

        if ($request->has('transportista') && $request->input('transportista') != '') {
            $datosActualizados['transportista'] = $request->input('transportista');
        }

        if ($fechaInstalacionNueva != '') {
            $datosActualizados['fecha_instalacion2'] = $fechaInstalacionNueva;
        }

        // Actualizar el instalador con el nuevo valor
        if ($instaladorNuevo != '') {
            $datosActualizados['instalador'] = $instaladorNuevo;
        }

        // Actualizar el bloque con el nuevo valor
        if ($bloqueNuevo != '') {
            $datosActualizados['bloque'] = $bloqueNuevo;
        }

        if (!empty($datosActualizados)) {
            $agendaDef->update($datosActualizados);
            return response()->json(['success' => 'Registro actualizado con éxito']);
        } else {
            return response()->json(['error' => 'No hay datos para actualizar'], 400);
        }
    } else {
        return response()->json(['error' => 'Registro no encontrado'], 404);
    }
}

    



    


    public function agenda3()
{
    $calendarioDef = CalendarioDef::all();

    $agendaItems = AgendaDef::all();


    $fechasInstalacion =$fechasInstalacion = CalendarioDef::orderBy('fecha_instalacion', 'asc')
    ->pluck('fecha_instalacion')
    ->unique();



    return view('agenda-def.agenda-globalkhem', [
        'calendarioDefs' => $calendarioDef,
        'agendaItems' => $agendaItems,
        'fechasInstalacion' => $fechasInstalacion
    ]);
}




public function agenda()
{
    // Obtiene todos los ítems de Agenda incluyendo su CalendarioDef relacionado
    $agendaItems = AgendaDef::with('calendarioDef')->get();

    // Recupera las fechas de instalación únicas de CalendarioDef
    $fechasInstalacion = AgendaDef::orderBy('fecha_instalacion2', 'asc')
                                       ->pluck('fecha_instalacion2')
                                       ->unique();

    // Pasar los datos a la vista
    return view('agenda-def.agenda-global', [
        'agendaItems' => $agendaItems,
        'fechasInstalacion' => $fechasInstalacion
    ]);
}





public function agenda2()
{
    return view('agenda-def.agendaindi');
}

public function showDetalle($id)
{
    $calendarioDef = CalendarioDef::findOrFail($id);

    $agendaItems = AgendaDef::all();
    $fechaInstalacion = $calendarioDef->fecha_instalacion ?? '-';
    $observacion = optional($calendarioDef->agendaDefs->first())->observacion_bloque;
    $notaresumida = optional($calendarioDef->agendaDefs->first())->nota_resumida;
    $fechaEntrega = optional($calendarioDef->agendaDefs->first())->fecha_entrega;

    $notaVenta = $calendarioDef->nota_venta ?? 'No definido';
    $cliente = $calendarioDef->cliente ?? 'No definido';

    $fechasInstalacion2 = AgendaDef::where('nota_venta', $notaVenta)
        ->whereNotNull('fecha_instalacion2')
        ->select('fecha_instalacion2')
        ->distinct()
        ->pluck('fecha_instalacion2')
        ->toArray();

    // Si no hay fechas de instalación 2, usar la fecha de instalación del CalendarioDef
    if (empty($fechasInstalacion2) && $fechaInstalacion !== '-') {
        $fechasInstalacion2 = [$fechaInstalacion];
    } elseif (empty($fechasInstalacion2)) {
        // Si tampoco hay fecha de instalación en CalendarioDef, dejar el array vacío
        $fechasInstalacion2 = [];
    }

    $infoCombinada = "NV: " . $notaVenta . "\nCliente: " . $cliente;

    return view('agenda-def.agenda', [
        'calendarioDef' => $calendarioDef,
        'agendaItems' => $agendaItems,
        'fechaInstalacion' => $fechaInstalacion,
        'observacion' => $observacion,
        'notaresumida' => $notaresumida,
        'fechaEntrega' => $fechaEntrega,
        'infoCombinada' => $infoCombinada,
        'fechasInstalacion2' => $fechasInstalacion2,
    ]);
}



public function showDetalle1($id)
{
    $calendarioDef1 = CalendarioDef::findOrFail($id);

    $agendaItems1 = AgendaDef::all();
    $fechaEntrega = optional($calendarioDef1->agendaDefs->first())->fecha_entrega;
    $nota_resumida = optional($calendarioDef1->agendaDefs->first())->nota_resumida;
    $instalador= optional($calendarioDef1->agendaDefs->first())->instalador;
    $observacion = optional($calendarioDef1->agendaDefs->first())->observacion_bloque;
   



    $notaVenta = $calendarioDef1->nota_venta ?? 'No definido';
    $cliente = $calendarioDef1->cliente ?? 'No definido'; 

    $infoCombinada = "NV: " . $notaVenta . "\nCliente: " . $cliente;
    

    $instaladorSesion = session('usuario') ? session('usuario')->NOMBRE : null;

    $bloque = AgendaDef::where('nota_venta', $calendarioDef1->nota_venta)
    ->where('instalador', $instaladorSesion)
    ->get()
    ->pluck('bloque')
    ->unique();

    $fechasInstalacion2 = AgendaDef::where('nota_venta', $notaVenta)
    ->where('instalador', $instaladorSesion) // Filtra por el instalador en sesión
    ->select('fecha_instalacion2')
    ->distinct()
    ->pluck('fecha_instalacion2');
    


    $nombreUsuario = session('usuario')->NOMBRE;
    $agendaDefFiltrados = $calendarioDef1->agendaDefs->filter(function ($item) use ($instaladorSesion) {
        return $item->instalador == $instaladorSesion;
    });

    return view('agenda-def.agendaindi', [
        'calendarioDef1' => $calendarioDef1,
        'agendaItems1' => $agendaItems1,
        'agendaDefFiltrados' => $agendaDefFiltrados,
        'fechaEntrega' => $fechaEntrega,
        'instalador' => $instalador,
        'observacion' => $observacion,
        'bloque' => $bloque,
        'infoCombinada' => $infoCombinada,
        'fechasInstalacion2' => $fechasInstalacion2,
        'nombreUsuario' => $nombreUsuario



    ]);
}

public function showDetalle3($id)
{
    $calendarioDef = CalendarioDef::findOrFail($id);
    $agendaItems = AgendaDef::all();
    $fechaInstalacion = $calendarioDef->first()->fecha_instalacion ?? null;
    $observacion = optional($calendarioDef->agendaDefs->first())->observacion_bloque;
    $notaresumida = optional($calendarioDef->agendaDefs->first())->nota_resumida;
    $fechaEntrega = optional($calendarioDef->agendaDefs->first())->fecha_entrega;

    $notaVenta = $calendarioDef->nota_venta ?? 'No definido';
    $cliente = $calendarioDef->cliente ?? 'No definido';

    $instaladoresFiltrados = ['STORETEK', 'SAN JOAQUIN', 'KHEMNOVA'];
    $fechasInstalacion2 = AgendaDef::where('nota_venta', $notaVenta)
        ->whereIn('instalador', $instaladoresFiltrados)
        ->select('fecha_instalacion2')
        ->distinct()
        ->pluck('fecha_instalacion2')
        ->toArray();

    // Incluye la fecha de instalación de CalendarioDef al principio del array
    if ($fechaInstalacion && !in_array($fechaInstalacion, $fechasInstalacion2)) {
        array_unshift($fechasInstalacion2, $fechaInstalacion);
    }

    $infoCombinada = "NV: " . $notaVenta . "\nCliente: " . $cliente;

    return view('agenda-def.agenda-khem', [
        'calendarioDef' => $calendarioDef,
        'agendaItems' => $agendaItems,
        'fechaInstalacion' => $fechaInstalacion,
        'observacion' => $observacion,
        'notaresumida' => $notaresumida,
        'fechaEntrega' => $fechaEntrega,
        'infoCombinada' => $infoCombinada,
        'fechasInstalacion2' => $fechasInstalacion2,
    ]);
}







public function obtenerFechasEntregaInstalador($nombreInstalador)
{
    $fechasEntrega = AgendaDef::where('instalador', $nombreInstalador)
                              ->orderBy('fecha_entrega', 'asc')
                              ->get()
                              ->pluck('fecha_entrega');

    return response()->json(['fechasEntrega' => $fechasEntrega]);
}

public function updateObservacion(Request $request, $id)
{
    $validatedData = $request->validate([
        'observacion_bloque' => 'required', 
    ]);

    $agendaDef = AgendaDef::findOrFail($id);
    $agendaDef->observacion_bloque = $validatedData['observacion_bloque'];
    $agendaDef->save();

    return redirect()->back()->with('success', 'Observación actualizada con éxito');
}



public function guardarMultiples(Request $request)
{
    Log::info('Datos recibidos:', $request->all());

    foreach ($request->all() as $datos) {
        $existente = AgendaDef::where('nota_venta', $datos['nota_venta'])
            ->where('transportista', $datos['transportista'])
            ->where('bloque', $datos['bloque'])
            ->where('fecha_entrega', $datos['fecha_entrega'])
            ->where('instalador', $datos['instalador'])
            ->where('observacion_bloque', $datos['observacion_bloque'])
            ->where('estado', $datos['estado'])
            ->where('nota_resumida2', $datos['nota_resumida2'])
            ->where('nota_resumida', $datos['nota_resumida'])
            ->where('fecha_instalacion2', $datos['fecha_instalacion2'])
            ->first();

        if (!$existente) {
            $agendaDef = new AgendaDef();
            $agendaDef->nota_venta = $datos['nota_venta'];
            $agendaDef->transportista = $datos['transportista'];
            $agendaDef->bloque = $datos['bloque'];
            $agendaDef->fecha_entrega = $datos['fecha_entrega'];
            $agendaDef->instalador = $datos['instalador'];
            $agendaDef->observacion_bloque = $datos['observacion_bloque'];
            $agendaDef->nota_resumida = $datos['nota_resumida'];
            $agendaDef->estado = $datos['estado'];
            $agendaDef->nota_resumida2 = $datos['nota_resumida2'];
            $agendaDef->fecha_instalacion2 = $datos['fecha_instalacion2'];
            $agendaDef->save();
        }
    }

    return response()->json(['success' => 'Requerimientos guardados con éxito']);
}







public function getBlockDescription($blockCode)
{
    $bloqueDescripcion = [
        'A-1' => 'BLOQUE A-1 (8:00-10:00)',
        'A-2' => 'BLOQUE A-2 (10:00-12:00)',
        'A-3' => 'BLOQUE A-3 (12:00-14:00)',
        'A-4' => 'BLOQUE A-4 (14:00-16:00)',
        'A-5' => 'BLOQUE A-5 (16:00-18:00)',
        'A-6' => 'BLOQUE A-6 (18:00-20:00)',
        'A-7' => 'BLOQUE A-7 (20:00-22:00)',
        'A-8' => 'BLOQUE A-8 (22:00-24:00)',

    ];

    return $bloqueDescripcion[$blockCode] ?? "Bloque no definido";
}








public function obtenerTransportistaPorBloque(Request $request)
{
    $bloque = $request->input('bloque');
    $instaladorNombre = $request->input('instalador');



    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->first();
    $transportista = $agendaDef ? $agendaDef->transportista : 'Completar Campo';

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'transportista' => $transportista
    ]);

}

public function obtenerNotaResumidaPorBloque(Request $request)
{
    $bloque = $request->input('bloque');
    $instaladorNombre = $request->input('instalador');
    $fechaInstalacion2 = $request->input('fecha_instalacion2');


    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->where('fecha_instalacion2', $fechaInstalacion2)

                          ->first();
    $notaResumida = $agendaDef ? $agendaDef->nota_resumida : 'Completar Campo';

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'notaResumida' => $notaResumida
    ]);
}




public function obtenerObservacionPorBloque(Request $request)
{
    $bloque = $request->input('bloque');
    $instaladorNombre = $request->input('instalador');

    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->first();
    $observacionBloque = $agendaDef ? $agendaDef->observacion_bloque : 'Completar Campo';

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'observacionBloque' => $observacionBloque
    ]);
}


public function obtenerObservacionPorBloque2(Request $request)
{
    $bloque = $request->input('bloque');
    $instaladorNombre = $request->input('instalador');
    $fechaInstalacion2 = $request->input('fecha_instalacion2');


    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->where('fecha_instalacion2', $fechaInstalacion2)
                          ->first();
    $nota_resumida2 = $agendaDef ? $agendaDef->nota_resumida2 : 'Completar Campo';

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'nota_resumida2' => $nota_resumida2
    ]);
}







public function obtenerNotaResumidaPorBloqueSesion(Request $request)
{
    Log::info('obtenerNotaResumidaPorBloqueSesion Request:', $request->all());

    $bloque = $request->input('bloque');
    $instaladorNombre = session('usuario')->NOMBRE;
    $fechaInstalacion2 = $request->input('fecha_instalacion2');

    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->where('fecha_instalacion2', $fechaInstalacion2)
                          ->first();
    $notaResumida = $agendaDef ? $agendaDef->nota_resumida2 : 'Completar Campo';

    Log::info('obtenerNotaResumidaPorBloqueSesion Response:', ['notaResumida' => $notaResumida]);

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'notaResumida' => $notaResumida
    ]);
}

public function obtenerObservacionPorBloqueSesion(Request $request)
{
    Log::info('obtenerObservacionPorBloqueSesion Request:', $request->all());

    $bloque = $request->input('bloque');
    $instaladorNombre = session('usuario')->NOMBRE;
    $fechaInstalacion2 = $request->input('fecha_instalacion2');

    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->where('fecha_instalacion2', $fechaInstalacion2)
                          ->first();
    $observacionBloque = $agendaDef ? $agendaDef->observacion_bloque : 'Completar Campo';

    Log::info('obtenerObservacionPorBloqueSesion Response:', ['observacionBloque' => $observacionBloque]);

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'observacionBloque' => $observacionBloque
    ]);
}





public function obtenerTransportistaPorBloqueSesion(Request $request)
{
    $bloque = $request->input('bloque');
    $instaladorNombre = $request->input('instalador');
    $fechaInstalacion2 = $request->input('fecha_instalacion2');



    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->where('fecha_instalacion2', $fechaInstalacion2)

                          
                          ->first();
    $transportista = $agendaDef ? $agendaDef->transportista : 'Completar Campo';

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'transportista' => $transportista
    ]);

}


public function calendarioDia()
{
    $calendarioDefs = CalendarioDef::all();
    $agendaItems = AgendaDef::all();
    $fechasInstalacion2 = AgendaDef::select('fecha_instalacion2')
                                    ->distinct()
                                    ->pluck('fecha_instalacion2');

    $infoCombinada = [];

    foreach ($calendarioDefs as $calendarioDef) {
        $notaVenta = $calendarioDef->nota_venta ?? 'No definido';
        $cliente = $calendarioDef->cliente ?? 'No definido';

        $primerAgendaDef = $calendarioDef->agendaDefs->first();

        $infoCombinada[] = [
            'calendarioDef' => $calendarioDef,
            'fechaInstalacion' => $calendarioDef->fecha_instalacion ?? null,
            'observacion' => optional($primerAgendaDef)->observacion_bloque,
            'notaresumida' => optional($primerAgendaDef)->nota_resumida,
            'fechaEntrega' => optional($primerAgendaDef)->fecha_entrega,
            'infoCombinada' => "NV: " . $notaVenta . "\nCliente: " . $cliente
        ];
    }


    $bloques = ['A-1', 'A-2', 'A-3', 'A-4', 'A-5', 'A-6', 'A-7', 'A-8'];

    $bloquesHorarios = [
        'A-1' => '08:00-10:00',
        'A-2' => '10:00-12:00',
        'A-3' => '12:00-14:00',
        'A-4' => '14:00-16:00',
        'A-5' => '16:00-18:00',
        'A-6' => '18:00-20:00',
        'A-7' => '20:00-22:00',
        'A-8' => '22:00-24:00',
    ];
    $instaladores = ['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA', 'KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'];

    return view('agenda-def.agenda-dia', [
        'infoCombinada' => $infoCombinada,
        'agendaItems' => $agendaItems,
        'fechasInstalacion2' => $fechasInstalacion2,
        'bloques' => $bloques,
        'instaladores' => $instaladores,
        'bloquesHorarios' => $bloquesHorarios,
    ]);
}






   





    public function store2(Request $request)
    {
        $validatedData = $request->validate([
            'nota_venta' => 'required',
            'instalador' => 'required',
            'bloque' => 'required',
            'observacion_bloque' => 'nullable',
            'estado' => 'required',
            'fecha_entrega' => 'nullable',
            'transportista' => 'required',
            'nota_resumida' => 'required',
            'nota_resumida2' => 'required',
            'fechas' => 'required', // Asegúrate de agregar esto
            
        ]);
    
        // Suponiendo que 'fechas' es una cadena con fechas separadas por comas
        $fechas = explode(',', $validatedData['fechas']);
    
        foreach ($fechas as $fecha) {
            $fecha = trim($fecha); // Eliminar espacios en blanco
            
            $agendaDef = new AgendaDef();
            $agendaDef->nota_venta = $validatedData['nota_venta'];
            $agendaDef->instalador = $validatedData['instalador'];
            $agendaDef->bloque = $validatedData['bloque'];
            $agendaDef->observacion_bloque = $validatedData['observacion_bloque'] ?? null;
            $agendaDef->estado = $validatedData['estado'];
            $agendaDef->fecha_entrega = $validatedData['fecha_entrega'] ?? null;
            $agendaDef->transportista = $validatedData['transportista'];
            $agendaDef->nota_resumida = $validatedData['nota_resumida'];
            $agendaDef->nota_resumida2 = $validatedData['nota_resumida2'];
            $agendaDef->fecha_instalacion2 = $fecha; // Agregar la fecha del bucle aquí
            
            $agendaDef->save();
        }

        return response()->json(['success' => 'Operación realizada exitosamente.']);

    
    }
    
    




    public function guardarPorFecha(Request $request)
{
    Log::info('Datos recibidos:', $request->all());

    foreach ($request->all() as $datos) {
        $fechas = $datos['fechas']; // Asume que 'fechas' es un array

        foreach ($fechas as $fecha) {
            $agendaDef = new AgendaDef();
            $agendaDef->nota_venta = $datos['nota_venta'];
            $agendaDef->transportista = $datos['transportista'];
            $agendaDef->bloque = $datos['bloque'];
            $agendaDef->fecha_entrega = $datos['fecha_entrega'];
            $agendaDef->instalador = $datos['instalador'];
            $agendaDef->observacion_bloque = $datos['observacion_bloque'];
            $agendaDef->nota_resumida = $datos['nota_resumida'];
            $agendaDef->estado = $datos['estado'];
            $agendaDef->nota_resumida2 = $datos['nota_resumida2'];
            $agendaDef->fecha_instalacion2 = $fecha; // Asigna la fecha actual del bucle
            $agendaDef->save();
        }
    }

    return response()->json(['success' => 'Requerimientos guardados con éxito']);
}

    






public function calendarioSemana()
{

    
    $calendarioDefs = CalendarioDef::all();
    $agendaItems = AgendaDef::all();
    $fechasInstalacion2 = AgendaDef::select('fecha_instalacion2')
                                    ->distinct()
                                    ->pluck('fecha_instalacion2');

                                    

    $infoCombinada = [];

    foreach ($calendarioDefs as $calendarioDef) {
        $notaVenta = $calendarioDef->nota_venta ?? 'No definido';
        $cliente = $calendarioDef->cliente ?? 'No definido';

        $primerAgendaDef = $calendarioDef->agendaDefs->first();
       

        $infoCombinada[] = [
            'calendarioDef' => $calendarioDef,
            'fechaInstalacion' => $calendarioDef->fecha_instalacion ?? null,
            'observacion' => optional($primerAgendaDef)->observacion_bloque,
            'notaresumida' => optional($primerAgendaDef)->nota_resumida,
            'fechaEntrega' => optional($primerAgendaDef)->fecha_entrega,
            'infoCombinada' => "NV: " . $notaVenta . "\nCliente: " . $cliente
        ];
    }


    $instaladoresPorFecha = [];
    foreach ($agendaItems as $item) {
        $fechaFormateada = \Carbon\Carbon::parse($item->fecha_instalacion2)->format('Y-m-d');
        $cliente = $item->calendarioDef->cliente ?? 'No definido';
        $estado = $item->estado ?? 'No definido'; // Agrega esta línea

        $calendarioDefId = $item->calendarioDef->id ?? null;
        $item->calendario_def_id = $calendarioDefId; // Agrega el id a cada objeto
    
        $item->nombre_cliente = $cliente;
        $item->estado = $estado; // Agrega esta línea
    
        $instaladoresPorFecha[$fechaFormateada][] = $item;
    }
    
    

\Carbon\Carbon::setLocale('es'); // Establece el locale de Carbon a español

    $startDate = Carbon::now()->startOfWeek();
    $weekDates = [];

    for ($i = 0; $i < 6; $i++) { // 6 porque estamos incluyendo hasta el sábado
        $weekDates[] = $startDate->copy()->addDays($i)->isoFormat('dddd, Y-M-D'); 
    }


    
    return view('agenda-def.agenda-semana', [
        'infoCombinada' => $infoCombinada,
        'agendaItems' => $agendaItems,
        'fechasInstalacion2' => $fechasInstalacion2,
        'weekDates' => $weekDates,
        'instaladoresPorFecha' => $instaladoresPorFecha, // Agrega esta línea
    ]);
    
    
}






    public function updateAgenda(Request $request)
    {
        $agendaItem = AgendaDef::where('nota_venta', $request->nota_venta)
                                ->where('bloque', $request->original_bloque)
                                ->where('instalador', $request->original_instalador)
                                ->where('fecha_instalacion2', $request->fecha_entrega)
                                ->first();

        if ($agendaItem) {
            // Actualizar los campos con los nuevos valores
            $agendaItem->instalador = $request->nuevo_instalador;
            $agendaItem->bloque = $request->nuevo_bloque;
            $agendaItem->transportista = $request->transportista;
            $agendaItem->observacion_bloque = $request->observaciones;
            $agendaItem->nota_resumida = $request->nota_resumida;
            $agendaItem->estado = $request->estado;
            $agendaItem->save();

            return response()->json(['success' => 'Datos actualizados correctamente']);
        }

        return response()->json(['error' => 'Registro no encontrado'], 404);
    }



public function obtenerEstado(Request $request){
    $bloque = $request->input('bloque');
    $instalador = $request->input('instalador');
    $fechaInstalacion2 = $request->input('fecha_instalacion2');

    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instalador)
                          ->where('fecha_instalacion2', $fechaInstalacion2)
                          ->first();
    
    // Si no encuentra registro, devolver null en lugar de "Completar Campo"
    $estado = $agendaDef ? $agendaDef->estado : null;

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instalador,
        'estado' => $estado
    ]);
}


public function obtenerEstado2(Request $request){
    $bloque = $request->input('bloque');
    $instaladorNombre = session('usuario')->NOMBRE;
    $fechaInstalacion2 = $request->input('fecha_instalacion2');

    $agendaDef = AgendaDef::where('bloque', $bloque)
                          ->where('instalador', $instaladorNombre)
                          ->where('fecha_instalacion2', $fechaInstalacion2)
                          ->first();
    $estado = $agendaDef ? $agendaDef->estado : null; // ✅ null en lugar de 'Completar Campo'

    return response()->json([
        'bloque' => $bloque,
        'instalador' => $instaladorNombre,
        'estado' => $estado
    ]);
}

/**
 * Mostrar detalle de nota de venta desde Softland (Admin)
 */
public function showDetalleSoftland($folio)
{
    try {
        // Buscar en Softland
        $notaSoftland = \App\Models\TablaSoftland::where('nv_folio', $folio)->firstOrFail();
        
        // Crear objeto temporal que simula CalendarioDef
        $calendarioDef = new \stdClass();
        $calendarioDef->id = $notaSoftland->nv_id;
        $calendarioDef->nota_venta = $notaSoftland->nv_folio;
        $calendarioDef->cliente = $notaSoftland->nv_cliente;
        $calendarioDef->descripcion = $notaSoftland->nv_descripcion;
        $calendarioDef->fecha_instalacion = $notaSoftland->nv_fentrega;
        $calendarioDef->fecha_fabril = $notaSoftland->nv_femision;
        $calendarioDef->ejecutivo = $notaSoftland->nv_vend;
        $calendarioDef->detalle = $notaSoftland->nv_descripcion;
        $calendarioDef->estado_bloque = null;
        $calendarioDef->estado_despacho = $notaSoftland->nv_estado;
        $calendarioDef->comentario = null;
        $calendarioDef->proyecto = null;
        
        // Obtener items de agenda asociados a esta nota de venta
        $agendaItems = AgendaDef::where('nota_venta', $folio)->get();
        
        // AGREGAR CLIENTE A CADA ITEM DE AGENDA
        foreach ($agendaItems as $item) {
            $item->calendarioDef = (object)[
                'cliente' => $notaSoftland->nv_cliente,
                'nota_venta' => $notaSoftland->nv_folio,
                'descripcion' => $notaSoftland->nv_descripcion,
            ];
        }
        
        // Crear relación simulada con agendaDefs
        $calendarioDef->agendaDefs = $agendaItems;
        
        // Obtener fechas de instalación únicas
        $fechasInstalacion2 = AgendaDef::where('nota_venta', $folio)
            ->whereNotNull('fecha_instalacion2')
            ->select('fecha_instalacion2')
            ->distinct()
            ->pluck('fecha_instalacion2')
            ->toArray();

        if (empty($fechasInstalacion2) && $calendarioDef->fecha_instalacion) {
            $fechasInstalacion2 = [$calendarioDef->fecha_instalacion];
        }

        $fechaInstalacion = $calendarioDef->fecha_instalacion ?? '-';
        $observacion = optional($agendaItems->first())->observacion_bloque;
        $notaresumida = optional($agendaItems->first())->nota_resumida;
        $fechaEntrega = optional($agendaItems->first())->fecha_entrega;
        
        $infoCombinada = "NV: " . $calendarioDef->nota_venta . "\nCliente: " . $calendarioDef->cliente;

        return view('agenda-def.agenda', [
            'calendarioDef' => $calendarioDef,
            'agendaItems' => $agendaItems,
            'fechaInstalacion' => $fechaInstalacion,
            'observacion' => $observacion,
            'notaresumida' => $notaresumida,
            'fechaEntrega' => $fechaEntrega,
            'infoCombinada' => $infoCombinada,
            'fechasInstalacion2' => $fechasInstalacion2,
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error al cargar detalle de Softland: ' . $e->getMessage());
        return redirect()->route('calendario')->with('error', 'No se encontró la nota de venta.');
    }
}

/**
 * Mostrar detalle de nota de venta desde Softland (Khemnova)
 */
public function showDetalleSoftlandKhem($folio)
{
    try {
        // Buscar en Softland
        $notaSoftland = \App\Models\TablaSoftland::where('nv_folio', $folio)->firstOrFail();
        
        // Crear objeto temporal
        $calendarioDef = new \stdClass();
        $calendarioDef->id = $notaSoftland->nv_id;
        $calendarioDef->nota_venta = $notaSoftland->nv_folio;
        $calendarioDef->cliente = $notaSoftland->nv_cliente;
        $calendarioDef->descripcion = $notaSoftland->nv_descripcion;
        $calendarioDef->fecha_instalacion = $notaSoftland->nv_fentrega;
        
        // Obtener items de agenda
        $agendaItems = AgendaDef::where('nota_venta', $folio)->get();
        
        $fechaInstalacion = $calendarioDef->fecha_instalacion ?? null;
        $observacion = optional($agendaItems->first())->observacion_bloque;
        $notaresumida = optional($agendaItems->first())->nota_resumida;
        $fechaEntrega = optional($agendaItems->first())->fecha_entrega;

        $instaladoresFiltrados = ['STORETEK', 'SAN JOAQUIN', 'KHEMNOVA'];
        $fechasInstalacion2 = AgendaDef::where('nota_venta', $folio)
            ->whereIn('instalador', $instaladoresFiltrados)
            ->select('fecha_instalacion2')
            ->distinct()
            ->pluck('fecha_instalacion2')
            ->toArray();

        if ($fechaInstalacion && !in_array($fechaInstalacion, $fechasInstalacion2)) {
            array_unshift($fechasInstalacion2, $fechaInstalacion);
        }

        $infoCombinada = "NV: " . $calendarioDef->nota_venta . "\nCliente: " . $calendarioDef->cliente;

        return view('agenda-def.agenda-khem', [
            'calendarioDef' => $calendarioDef,
            'agendaItems' => $agendaItems,
            'fechaInstalacion' => $fechaInstalacion,
            'observacion' => $observacion,
            'notaresumida' => $notaresumida,
            'fechaEntrega' => $fechaEntrega,
            'infoCombinada' => $infoCombinada,
            'fechasInstalacion2' => $fechasInstalacion2,
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error al cargar detalle Khem: ' . $e->getMessage());
        return redirect()->route('calendario4')->with('error', 'No se encontró la nota de venta.');
    }
}

/**
 * Mostrar detalle de nota de venta desde Softland (Instalador)
 */
public function showDetalleSoftlandInstalador($folio)
{
    try {
        // Buscar en Softland
        $notaSoftland = \App\Models\TablaSoftland::where('nv_folio', $folio)->firstOrFail();
        
        // Crear objeto temporal
        $calendarioDef1 = new \stdClass();
        $calendarioDef1->id = $notaSoftland->nv_id;
        $calendarioDef1->nota_venta = $notaSoftland->nv_folio;
        $calendarioDef1->cliente = $notaSoftland->nv_cliente;
        $calendarioDef1->descripcion = $notaSoftland->nv_descripcion;
        $calendarioDef1->fecha_instalacion = $notaSoftland->nv_fentrega;
        
        // Obtener items de agenda
        $agendaItems1 = AgendaDef::where('nota_venta', $folio)->get();
        
        $instaladorSesion = session('usuario') ? session('usuario')->NOMBRE : null;
        
        // Filtrar agendas por instalador de sesión
        $agendaDefFiltrados = $agendaItems1->where('instalador', $instaladorSesion);
        
        $fechaEntrega = optional($agendaDefFiltrados->first())->fecha_entrega;
        $nota_resumida = optional($agendaDefFiltrados->first())->nota_resumida;
        $instalador = optional($agendaDefFiltrados->first())->instalador;
        $observacion = optional($agendaDefFiltrados->first())->observacion_bloque;
        
        $bloque = AgendaDef::where('nota_venta', $folio)
            ->where('instalador', $instaladorSesion)
            ->pluck('bloque')
            ->unique();

        $fechasInstalacion2 = AgendaDef::where('nota_venta', $folio)
            ->where('instalador', $instaladorSesion)
            ->select('fecha_instalacion2')
            ->distinct()
            ->pluck('fecha_instalacion2');
        
        $infoCombinada = "NV: " . $calendarioDef1->nota_venta . "\nCliente: " . $calendarioDef1->cliente;
        
        $nombreUsuario = session('usuario')->NOMBRE;

        return view('agenda-def.agendaindi', [
            'calendarioDef1' => $calendarioDef1,
            'agendaItems1' => $agendaItems1,
            'agendaDefFiltrados' => $agendaDefFiltrados,
            'fechaEntrega' => $fechaEntrega,
            'instalador' => $instalador,
            'observacion' => $observacion,
            'bloque' => $bloque,
            'infoCombinada' => $infoCombinada,
            'fechasInstalacion2' => $fechasInstalacion2,
            'nombreUsuario' => $nombreUsuario
        ]);
        
    } catch (\Exception $e) {
        Log::error('Error al cargar detalle instalador: ' . $e->getMessage());
        return redirect()->route('calendario3')->with('error', 'No se encontró la nota de venta.');
    }
}



}

