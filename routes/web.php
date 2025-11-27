<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AgendaDefController;
use App\Http\Controllers\CalendarioDefController;

Route::post('/login', [AuthController::class, 'login1']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('login');
})->name('inicio');

Route::group(['prefix' => 'calendario-def', 'middleware' => ['custom.session']], function () {
    Route::get('/calendario', [CalendarioDefController::class, 'calendario'])->name('calendario')->middleware('checkRole:1');
    Route::post('/actualizar-fechas-nvgestion', [CalendarioDefController::class, 'actualizarFechasDesdeNvgestion'])->name('calendario.actualizar-fechas')->middleware('checkRole:1');
    Route::resource('calendario_def', CalendarioDefController::class);
    Route::get('/agendainstalador', [CalendarioDefController::class, 'calendario2'])->name('calendario2')->middleware('checkRole:3');
    Route::get('/calendarioinstalador', [CalendarioDefController::class, 'calendario3'])->name('calendario3')->middleware('checkRole:3');
    Route::delete('/{id}', [CalendarioDefController::class, 'destroy'])->name('calendario_def.destroy')->middleware('checkRole:1');
    Route::get('/calendario/Khemnova', [CalendarioDefController::class, 'calendario4'])->name('calendario4')->middleware('checkRole:2');
});

Route::group(['prefix' => 'agenda-def','middleware' => ['custom.session']], function () {
    Route::resource('agenda_def', AgendaDefController::class);
    Route::get('/agenda', [AgendaDefController::class, 'agenda'])->name('agenda')->middleware('checkRole:1');
    Route::get('/agenda/Instaladores', [AgendaDefController::class, 'agenda2'])->name('agenda2')->middleware('checkRole:3');
    Route::get('/agenda/Khemnova', [AgendaDefController::class, 'agenda3'])->name('agenda5')->middleware('checkRole:2');

    // RUTAS DE DETALLE ACTUALIZADAS PARA SOFTLAND
    Route::get('/detalle-softland/{folio}', [AgendaDefController::class, 'showDetalleSoftland'])->name('agenda3')->middleware('checkRole:1');
    Route::get('/detalle-softland-khem/{folio}', [AgendaDefController::class, 'showDetalleSoftlandKhem'])->name('agenda6')->middleware('checkRole:2');
    Route::get('/detalle-softland-instalador/{folio}', [AgendaDefController::class, 'showDetalleSoftlandInstalador'])->name('agenda4')->middleware('checkRole:3');

    Route::get('/agenda-dia', [AgendaDefController::class, 'calendarioDia'])->name('calendariodia')->middleware('checkRole:1');
    Route::get('/agenda-semana', [AgendaDefController::class, 'calendarioSemana'])->name('calendariosemana')->middleware('checkRole:1');

    Route::post('/store', [AgendaDefController::class, 'store'])->name('agenda_def.store');
    Route::post('/store3', [AgendaDefController::class, 'store3'])->name('agenda_def.store3');

    Route::delete('/eliminar', [AgendaDefController::class, 'destroy1'])->name('eliminar-agenda-def');
    // ✅ NUEVA RUTA: Eliminar múltiples registros
    Route::post('/eliminar-multiples', [AgendaDefController::class, 'destroyMultiple'])->name('eliminar-agenda-multiples');
    
    Route::put('/update-observacion/{id}', [AgendaDefController::class, 'updateObservacion'])->name('agenda-def.update-observacion');
    Route::put('/ruta-de-actualizacion', [AgendaDefController::class, 'update1'])->name('ruta-de-actualizacion');
    Route::put('/ruta-de-actualizacion2', [AgendaDefController::class, 'update2'])->name('ruta-de-actualizacion2');

    Route::get('/fechas-entrega-instalador/{nombreInstalador}', [AgendaDefController::class, 'obtenerFechasEntregaInstalador']);
    Route::post('/ruta-para-guardar-multiple', [AgendaDefController::class, 'guardarMultiples']);
});

Route::post('/ruta-para-obtener-transportista', [AgendaDefController::class, 'obtenerTransportistaPorBloque']);	
Route::post('/ruta-para-obtener-nota-resumida', [AgendaDefController::class, 'obtenerNotaResumidaPorBloque']);
Route::post('/ruta-para-obtener-observacion', [AgendaDefController::class, 'obtenerObservacionPorBloque']);
Route::post('/ruta-para-obtener-nota', [AgendaDefController::class, 'obtenerObservacionPorBloque2']);

Route::post('/ruta-para-obtener-transportista2', [AgendaDefController::class, 'obtenerTransportistaPorBloqueSesion']);	
Route::post('/ruta-para-obtener-nota-resumida2', [AgendaDefController::class, 'obtenerNotaResumidaPorBloqueSesion']);
Route::post('/ruta-para-obtener-observacion2', [AgendaDefController::class, 'obtenerObservacionPorBloqueSesion']);
Route::put('/actualizacion/{calendario_def}', [CalendarioDefController::class, 'update'])->name('actualizacion');

Route::post('/guardar-agenda',[AgendaDefController::class,'store2']);
Route::post('/guardar-agenda2',[AgendaDefController::class,'guardarPorFecha']);

Route::post('/update-agenda', [AgendaDefController::class, 'updateAgenda'])->name('update.agenda');

Route::post('/ruta-para-obtener-estado', [AgendaDefController::class, 'obtenerEstado']);
Route::post('/ruta-para-obtener-estado2', [AgendaDefController::class, 'obtenerEstado2']);

Route::post('/calendario-def/{id}/actualizar-proyecto', [CalendarioDefController::class, 'actualizarProyecto'])->name('calendario-def.actualizar-proyecto');

Route::post('/obtener-zona', [AgendaDefController::class, 'obtenerZona']);
Route::post('/guardar-zona', [AgendaDefController::class, 'guardarZona']);
