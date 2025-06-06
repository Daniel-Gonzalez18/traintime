<?php

namespace App\Http\Controllers;
// use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Client;
use OpenAI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Routine;


class OpenAIController extends Controller
{
    public function createRoutine(Request $request){
        $data = $request->all();

        $prompt = "Generame explicitamente un json sin nada de texto ni markdown, en español y con comillas dobles, una sesion de entrenamiento  para una persona que mide ". $data['altura']. "cm y pesa ".$data['peso']." , el nivel de gimnasio es de ".$data['experiencia']." , la finalidad que quiere con el gimanisio es ".$data['objetivo'].". Quiere ir ".$data['numDias']." dias al gimnasio y son ";
        foreach ($data['diasData'] as $value) {
            $prompt = $prompt.$value['nombre']." de ".$value['inicio'] ." a ".$value['fin']." , ";
        }
        $prompt= $prompt. ' . Quiero que sea una estructura clara en la que sea rutina con cada dia de entrnamiento, deontro del dia tenga los ejercicios con su nombres, descanso,repeticiones y series y despues en otro array los horarios dentro del array rutina. Que tenga siempre una estructura como la siguiente: {
	"rutina": [
    	{
        	"dia": "lunes",
        	"ejercicios": [
            	{
                	"nombre": "Sentadilla",
                	"series": 4,
                	"descanso": "90 segundos",
                	"repeticiones": 10
            	},
            	{
                	"nombre": "Peso muerto",
                	"series": 4,
                	"descanso": "90 segundos",
                	"repeticiones": 8
            	},
            	{
                	"nombre": "Press de banca",
                	"series": 4,
                	"descanso": "60 segundos",
                	"repeticiones": 10
            	},
            	{
                	"nombre": "Dominadas",
                	"series": 3,
                	"descanso": "60 segundos",
                	"repeticiones": 8
            	},
            	{
                	"nombre": "Crunch abdominal",
                	"series": 3,
                	"descanso": "30 segundos",
                	"repeticiones": 15
            	}
        	]
    	},
    	{
        	"dia": "miércoles",
        	"ejercicios": [
            	{
                	"nombre": "Prensa de pierna",
                	"series": 4,
                	"descanso": "90 segundos",
                	"repeticiones": 10
            	},
            	{
                	"nombre": "Press militar con mancuernas",
                	"series": 3,
                	"descanso": "60 segundos",
                	"repeticiones": 10
            	},
            	{
                	"nombre": "Remo con barra",
                	"series": 4,
                	"descanso": "90 segundos",
                	"repeticiones": 8
            	},
            	{
                	"nombre": "Curl de bíceps",
                	"series": 3,
                	"descanso": "60 segundos",
                	"repeticiones": 12
            	},
            	{
                	"nombre": "Extensión de tríceps en polea",
                	"series": 3,
                	"descanso": "60 segundos",
                	"repeticiones": 12
            	}
        	]
    	},
    	{
        	"dia": "viernes",
        	"ejercicios": [
            	{
                	"nombre": "Zancadas",
                	"series": 3,
                	"descanso": "60 segundos",
                	"repeticiones": 12
            	},
            	{
                	"nombre": "Press inclinado con mancuernas",
                	"series": 4,
                	"descanso": "60 segundos",
                	"repeticiones": 10
            	},
            	{
                	"nombre": "Pull-over",
                	"series": 3,
                	"descanso": "60 segundos",
                	"repeticiones": 12
            	},
            	{
                	"nombre": "Elevaciones laterales",
                	"series": 3,
                	"descanso": "45 segundos",
                	"repeticiones": 15
            	},
            	{
                	"nombre": "Plancha",
                	"series": 3,
                	"descanso": "30 segundos",
                	"duración": "60 segundos"
            	}
        	]
    	}
	],
	"horarios": [
    	{
        	"dia": "lunes",
        	"hora_fin": "22:00",
        	"hora_inicio": "20:00"
    	},
    	{
        	"dia": "miércoles",
        	"hora_fin": "22:00",
        	"hora_inicio": "20:00"
    	},
    	{
        	"dia": "viernes",
        	"hora_fin": "22:00",
        	"hora_inicio": "20:00"
    	}
	]
}
';
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un entrenador personal experto en rutinas de gimnasio.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);
        $content = $response->choices[0]->message->content;
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->route('home')->with('error', 'Error al interpretar la respuesta de OpenAI');
        }
        $user = Auth::user();
        $rutina = new Routine();
        $rutina->user_id = $user->id;
        $rutina->contenido = $content;
        $rutina->save();
        return redirect()->route('calendar.events');
    }
}
