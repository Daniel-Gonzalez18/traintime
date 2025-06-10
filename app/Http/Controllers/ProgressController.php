<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Progress;
use Carbon\Carbon;
use Inertia\Inertia;
class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $user =Auth::user();
        $progress_day=$request->input('progreso');
        $fecha=Carbon::now()->toDateString(); 
        $dia_semana = Carbon::now()->locale('es')->isoFormat('dddd');
         foreach ($progress_day as $ejercicio) {
          
           $repeticiones=0;
           $peso=0;
           $contador=0;
           foreach ($ejercicio['series'] as $value) {
            $repeticiones=$repeticiones+$value["repeticiones"];
            $peso=$peso+$value["peso"];
            $contador++;
            
           }
           $repeticiones=$repeticiones/$contador;
           $peso=$peso/$contador;
           $rm=$peso * (1 + $repeticiones / 30);
           $progress= new Progress();
           $progress->user_id= $user->id;
           $progress->name_exercise=$ejercicio['nombre'];
           $progress->day= $dia_semana;
           $progress->fecha=$fecha;
           $progress->rm=$rm;
           $progress->save();
        }
         return redirect()->route('rutina');
    }
    public function mostrarProgresos(){
        $user= Auth::user();
        $progresos = Progress::where('user_id', $user->id)
        ->orderByRaw("FIELD(day, 'lunes','martes','miércoles','jueves','viernes','sábado','domingo')")
        ->orderBy('name_exercise')
        ->orderBy('fecha')
        ->get();

        $agrupados = [];

foreach ($progresos as $progreso) {
    $dia = $progreso->day;
    $ejercicio = $progreso->name_exercise;
    if (!isset($agrupados[$dia])) {
        $agrupados[$dia] = [];
    }
    if (!isset($agrupados[$dia][$ejercicio])) {
        $agrupados[$dia][$ejercicio] = [];
    }
    $agrupados[$dia][$ejercicio][] = [
        'fecha' => $progreso->fecha,
        'rm' => $progreso->rm,
    ];
}



       
        return Inertia::render('Progreso',[
            'progresos'=> $agrupados
        ]); 
    }
    
}
