<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Progress;

class RoutineController extends Controller
{
    public function checkRoutine(){
         $user = Auth::user();
         
         if (!$user->calendar_access_token) {
            return redirect()->route('rutina.calendar');
        }
        else {
            if ( $user->routine == null) {
                return redirect()->route('rutina.crear');
            }else{
                return redirect()->route('rutina.dia');
            }
        }
        
    }
    public function routineDay(Request $request){
        $user=Auth::user();
        $rutina = json_decode($user->routine->contenido, true);
        $hoy =strtolower(Carbon::now('Europe/Madrid')->locale('es')->isoFormat('dddd')); 
        $diasEntrenamiento=[];
        foreach ($rutina["rutina"] as $value) {
           array_push($diasEntrenamiento, $value['dia']);
        }
        $esDiaDeEntrenamiento = in_array($hoy, $diasEntrenamiento);
        $ejerciciosHoy = [];
        if ($esDiaDeEntrenamiento) {
           foreach ($rutina['rutina'] as $diaTraining) {
                if (strtolower($diaTraining['dia']) === $hoy) {
                    $ejerciciosHoy = $diaTraining['ejercicios'];
                    break;
                }
        }
        
    }
    $fechaHoy = Carbon::now('Europe/Madrid')->toDateString();
    $entrenamientoCompletado = Progress::where('user_id', $user->id)
        ->where('fecha', $fechaHoy)
        ->exists();
        

        return  Inertia::render('RutinaDia', [
            'ejerciciosHoy' => $ejerciciosHoy,
            'entrenamientoCompletado'=>$entrenamientoCompletado,
        ]);
    }
}
