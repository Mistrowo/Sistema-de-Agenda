<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgendaDefController;
use App\Http\Controllers\CalendarioDefController;

Route::post('/login', [AuthController::class, 'login1']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('login');
})->name('inicio');

Route::group(['prefix' => 'calendario-def', 'middleware' => ['custom.session']], function () {
    // Rutas de solo lectura (roles 1, 2, 3)
    Route::get('/calendario', [CalendarioDefController::class, 'calendario'])
        ->name('calendario')
        ->middleware('checkPermission:1,2,3');
    
    Route::get('/agendainstalador', [CalendarioDefController::class, 'calendario2'])
        ->name('calendario2')
        ->middleware('checkPermission:1,3');
    
    Route::get('/calendarioinstalador', [CalendarioDefController::class, 'calendario3'])
        ->name('calendario3')
        ->middleware('checkPermission:1,3');
    
    Route::get('/calendario/Khemnova', [CalendarioDefController::class, 'calendario4'])
        ->name('calendario4')
        ->middleware('checkPermission:1,2');

    // Rutas de escritura (solo rol 1)
    Route::post('/actualizar-fechas-nvgestion', [CalendarioDefController::class, 'actualizarFechasDesdeNvgestion'])
        ->name('calendario.actualizar-fechas')
        ->middleware('checkPermission:1');
    
    Route::delete('/{id}', [CalendarioDefController::class, 'destroy'])
        ->name('calendario_def.destroy')
        ->middleware('checkPermission:1');
    
    Route::put('/actualizacion/{calendario_def}', [CalendarioDefController::class, 'update'])
        ->name('actualizacion')
        ->middleware('checkPermission:1');
    
    Route::post('/{id}/actualizar-proyecto', [CalendarioDefController::class, 'actualizarProyecto'])
        ->name('calendario-def.actualizar-proyecto')
        ->middleware('checkPermission:1');
    
    Route::resource('calendario_def', CalendarioDefController::class)
        ->middleware('checkPermission:1');
});

Route::group(['prefix' => 'agenda-def','middleware' => ['custom.session']], function () {
    // Rutas de solo lectura
    Route::get('/agenda', [AgendaDefController::class, 'agenda'])
        ->name('agenda')
        ->middleware('checkPermission:1,2,3');
    
    Route::get('/agenda/Instaladores', [AgendaDefController::class, 'agenda2'])
        ->name('agenda2')
        ->middleware('checkPermission:1,3');
    
    Route::get('/agenda/Khemnova', [AgendaDefController::class, 'agenda3'])
        ->name('agenda5')
        ->middleware('checkPermission:1,2');

    // Rutas de detalle (lectura)
    Route::get('/detalle-softland/{folio}', [AgendaDefController::class, 'showDetalleSoftland'])
        ->name('agenda3')
        ->middleware('checkPermission:1,2,3');
    
    Route::get('/detalle-softland-khem/{folio}', [AgendaDefController::class, 'showDetalleSoftlandKhem'])
        ->name('agenda6')
        ->middleware('checkPermission:1,2');
    
    Route::get('/detalle-softland-instalador/{folio}', [AgendaDefController::class, 'showDetalleSoftlandInstalador'])
        ->name('agenda4')
        ->middleware('checkPermission:1,3');

    Route::get('/agenda-dia', [AgendaDefController::class, 'calendarioDia'])
        ->name('calendariodia')
        ->middleware('checkPermission:1,2,3');
    
    Route::get('/agenda-semana', [AgendaDefController::class, 'calendarioSemana'])
        ->name('calendariosemana')
        ->middleware('checkPermission:1,2,3');

    Route::get('/fechas-entrega-instalador/{nombreInstalador}', [AgendaDefController::class, 'obtenerFechasEntregaInstalador'])
        ->middleware('checkPermission:1,2,3');

    // Rutas de escritura (solo rol 1)
    Route::post('/store', [AgendaDefController::class, 'store'])
        ->name('agenda_def.store')
        ->middleware('checkPermission:1');
    
    Route::post('/store3', [AgendaDefController::class, 'store3'])
        ->name('agenda_def.store3')
        ->middleware('checkPermission:1');

    Route::delete('/eliminar', [AgendaDefController::class, 'destroy1'])
        ->name('eliminar-agenda-def')
        ->middleware('checkPermission:1');
    
    Route::post('/eliminar-multiples', [AgendaDefController::class, 'destroyMultiple'])
        ->name('eliminar-agenda-multiples')
        ->middleware('checkPermission:1');
    
    Route::put('/update-observacion/{id}', [AgendaDefController::class, 'updateObservacion'])
        ->name('agenda-def.update-observacion')
        ->middleware('checkPermission:1');
    
    Route::put('/ruta-de-actualizacion', [AgendaDefController::class, 'update1'])
        ->name('ruta-de-actualizacion')
        ->middleware('checkPermission:1');
    
    Route::put('/ruta-de-actualizacion2', [AgendaDefController::class, 'update2'])
        ->name('ruta-de-actualizacion2')
        ->middleware('checkPermission:1');

    Route::post('/ruta-para-guardar-multiple', [AgendaDefController::class, 'guardarMultiples'])
        ->middleware('checkPermission:1');
    
    Route::post('/obtener-zona', [AgendaDefController::class, 'obtenerZona'])
        ->middleware('checkPermission:1,2,3');
    
    Route::post('/guardar-zona', [AgendaDefController::class, 'guardarZona'])
        ->middleware('checkPermission:1');
    
    Route::resource('agenda_def', AgendaDefController::class)
        ->middleware('checkPermission:1');
});

// Rutas compartidas
Route::post('/ruta-para-obtener-transportista', [AgendaDefController::class, 'obtenerTransportistaPorBloque'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-nota-resumida', [AgendaDefController::class, 'obtenerNotaResumidaPorBloque'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-observacion', [AgendaDefController::class, 'obtenerObservacionPorBloque'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-nota', [AgendaDefController::class, 'obtenerObservacionPorBloque2'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-transportista2', [AgendaDefController::class, 'obtenerTransportistaPorBloqueSesion'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-nota-resumida2', [AgendaDefController::class, 'obtenerNotaResumidaPorBloqueSesion'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-observacion2', [AgendaDefController::class, 'obtenerObservacionPorBloqueSesion'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/guardar-agenda',[AgendaDefController::class,'store2'])
    ->middleware(['custom.session', 'checkPermission:1']);

Route::post('/guardar-agenda2',[AgendaDefController::class,'guardarPorFecha'])
    ->middleware(['custom.session', 'checkPermission:1']);

Route::post('/update-agenda', [AgendaDefController::class, 'updateAgenda'])
    ->name('update.agenda')
    ->middleware(['custom.session', 'checkPermission:1']);

Route::post('/ruta-para-obtener-estado', [AgendaDefController::class, 'obtenerEstado'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);

Route::post('/ruta-para-obtener-estado2', [AgendaDefController::class, 'obtenerEstado2'])
    ->middleware(['custom.session', 'checkPermission:1,2,3']);