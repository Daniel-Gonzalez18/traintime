<?php

namespace App\Http\Controllers;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Carbon\Carbon;
use Inertia\Inertia;


class CalendarController extends Controller
{   
    
    public function createEventFromRoutine(){
        if (!$user->calendar_access_token) {
            return redirect('/auth/google');
        }
        $user=Auth::user();
    $client = new Google_Client();
    $client->setClientId(config('services.google.client_id'));
    $client->setClientSecret(config('services.google.client_secret'));
    $client->setRedirectUri(config('services.google.redirect'));
    $client->setAccessType('offline');
    $client->setPrompt('consent');
    $client->addScope(Google_Service_Calendar::CALENDAR);

 


    $token = [
        'access_token' => $user->calendar_access_token,
        'refresh_token' => $user->calendar_refresh_token,
        'expires_in' => $user->calendar_expires_in   ,
    ];
        $client->setAccessToken($token);
        if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        $newToken = $client->getAccessToken();
        $user->calendar_access_token = $newToken['access_token'];
        $user->save();
        }

        $service = new Google_Service_Calendar($client);

        $rutina=json_decode($user->routine->contenido,true);
         $diasCarbon = [
        'lunes' => Carbon::MONDAY,
        'martes' => Carbon::TUESDAY,
        'miércoles' => Carbon::WEDNESDAY,
        'jueves' => Carbon::THURSDAY,
        'viernes' => Carbon::FRIDAY,
        'sábado' => Carbon::SATURDAY,
        'domingo' => Carbon::SUNDAY,
    ];
     foreach ($rutina['rutina'] as $key => $value) {
        foreach($rutina['horarios'] as $horas){
             if($horas['dia']==$value['dia']){
                $hora_inicio=$horas['hora_inicio'];
                $hora_final=$horas['hora_fin'];
            }
        }       
    $carbonDay = Carbon::now()->next($diasCarbon[$value['dia']]);
    $descripcion = "";
        foreach ($value['ejercicios'] as $ejercicio) {
        if (isset($ejercicio['repeticiones'])) {
                $descripcion .= " {$ejercicio['nombre']} , Series: {$ejercicio['series']} , Repeticiones: {$ejercicio['repeticiones']} , Descanso: {$ejercicio['descanso']}\n";

        }else{
            if (isset($ejercicio['duración'])) {
                                $descripcion .= " {$ejercicio['nombre']} , Series: {$ejercicio['series']} , Duracion: {$ejercicio['duracion']} , Descanso: {$ejercicio['descanso']}\n";

            }else{
                                $descripcion .= " {$ejercicio['nombre']} , Series: {$ejercicio['series']} , Descanso: {$ejercicio['descanso']}\n";

            }
        }
    }   
        $start = Carbon::parse("{$carbonDay->toDateString()} {$hora_inicio}", 'Europe/Madrid');
        $end = Carbon::parse("{$carbonDay->toDateString()} {$hora_final}", 'Europe/Madrid');

        $event = new Google_Service_Calendar_Event([
            'summary' => "Entrenamiento de {$value['dia']}",
            'description' => $descripcion,
            'start' => [
                'dateTime' => $start->toIso8601String(),
                'timeZone' => 'Europe/Madrid',
            ],
            'end' => [
                'dateTime' => $end->toIso8601String(),
                'timeZone' => 'Europe/Madrid',
            ],
             'recurrence' => [
                'RRULE:FREQ=WEEKLY;COUNT=6',
            ],
        ]);
        $calendarId = 'primary';
        $service->events->insert($calendarId, $event);
        

        
    }
    return redirect()->route('home');
}


    public function mostrarEventos(){
           $diasCarbon = [
        'lunes' => Carbon::MONDAY,
        'martes' => Carbon::TUESDAY,
        'miércoles' => Carbon::WEDNESDAY,
        'jueves' => Carbon::THURSDAY,
        'viernes' => Carbon::FRIDAY,
        'sábado' => Carbon::SATURDAY,
        'domingo' => Carbon::SUNDAY,
    ];
        $user= Auth::user();
        $eventosFullCalendar=[];
        $hora_final=null;
        $hora_inicio=null;
        if($user->routine){
            $rutina = json_decode($user->routine->contenido, true);
            foreach ($rutina['rutina'] as $key => $value) {
                foreach($rutina['horarios'] as $horas){
                    if($horas['dia']==$value['dia']){
                        $hora_inicio=$horas['hora_inicio'];
                        $hora_final=$horas['hora_fin'];
                    }
                }
                
                $carbonDay = Carbon::now()->next($diasCarbon[$value['dia']]);
                $descripcion = "";
    foreach ($value['ejercicios'] as $ejercicio) {
         
        if (isset($ejercicio['repeticiones'])) {
                $descripcion .= " {$ejercicio['nombre']} , Series: {$ejercicio['series']} , Repeticiones: {$ejercicio['repeticiones']} , Descanso: {$ejercicio['descanso']}\n";

        }else{
            if (isset($ejercicio['duración'])) {
                                $descripcion .= " {$ejercicio['nombre']} , Series: {$ejercicio['series']} , Duracion: {$ejercicio['duración']} , Descanso: {$ejercicio['descanso']}\n";

            }else{
                                $descripcion .= " {$ejercicio['nombre']} , Series: {$ejercicio['series']} , Descanso: {$ejercicio['descanso']}\n";

            }
        }
    }  

        for ($i = 0; $i < 4; $i++) {
       $fecha = $carbonDay->copy()->addWeeks($i);
        
        $start = Carbon::parse("{$fecha->toDateString()} {$hora_inicio}", 'Europe/Madrid');
        $end = Carbon::parse("{$fecha->toDateString()} {$hora_final}", 'Europe/Madrid');

       $eventosFullCalendar[] = [
            'title' => "Entrenamiento de {$value['dia']}",
            'start' => $start->toIso8601String(),
            'end' => $end->toIso8601String(),
            'extendedProps' => [
                'descripcion' => $descripcion
            ],
        ];
        }
        }
    }
    return Inertia::render('Calendario', [
        'calendarToken' => $user->calendar_access_token,
        'eventosFullCalendar' => $eventosFullCalendar]);
}
}