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
        ->orderBy('name')
        ->orderByRaw("FIELD(day, 'lunes','martes','miércoles','jueves','viernes','sábado','domingo')")
        ->orderBy('fecha')
        ->get()
        ->groupBy('name');

        $simplified = [];

    foreach ($progresos as $nombre => $listaProgresos) {
        foreach ($listaProgresos as $p) {
            $simplified[$nombre][] = [
                'dia' => $p['dia'] ?? $p['day'],
                'name_exercise' => $p['name_exercise'],
                'rm' => $p['rm'],
                'fecha' => $p['fecha'],
            ];
        }
    }    
        return Inertia::render('Progreso',[
            'progresos'=> $simplified
        ]); 
    }
    
}
