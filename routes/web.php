<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\CalendarController as AuthCalendarController;;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\GroupsController;



Route::get('/home', function () {
    return Inertia::render('Inicio');
})->middleware(['auth', 'verified'])->name('home');
Route::middleware('auth')->get('/', function () {
    return redirect()->route('login');
});
Route::get('/group', [GroupsController::class  ,'mostrarGrupos'])->middleware(['auth', 'verified'])->name('grupo');
Route::post('/routine', [RoutineController::class, 'store'])->name('rutina.store');
Route::get('/calendar', [CalendarController::class, "mostrarEventos"])->middleware(['auth', 'verified'])->name('calendario');
Route::get('/progress', [ProgressController::class,'mostrarProgresos'])->middleware(['auth', 'verified'])->name('progreso');
Route::post('/progress/store', [ProgressController::class, 'store'])->middleware(['auth', 'verified'])->name('progress.store');
Route::get('/routine', [RoutineController::class, 'checkRoutine'])->middleware(['auth', 'verified'])->name('rutina');
Route::get('/routine/day', [RoutineController::class, 'routineDay'])->middleware(['auth', 'verified'])->name('rutina.dia');
Route::get('/routine/create', function () {
    return Inertia::render('RutinaCrear');
})->middleware(['auth', 'verified'])->name('rutina.crear');
Route::get('/routine/calendar', function (){
    return Inertia::render('RutinaCalendar');
})->middleware(['auth', 'verified'])->name('rutina.calendar');
Route::get('/auth/google', [AuthCalendarController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthCalendarController::class, 'handleGoogleCallback'])->middleware(['auth']);
Route::post('/generate-routine', [OpenAIController::class, 'createRoutine'])->middleware(['auth', 'verified'])->name('create-routine');
Route::get('/calendar/regiterevents',[CalendarController::class, "createEventFromRoutine"])->middleware(['auth', 'verified'])->name('calendar.events');
Route::get('/verification', function(){
    return Inertia::render('Verificacion');
})->name('verificacion');
Route::post('/group/store',[GroupsController::class,"store"])->middleware(['auth','verified'])->name('group.store');
Route::get('/create/group',function(){
    return Inertia::render('CrearGrupo');
})->middleware(['auth','verified'])->name('create.group');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
