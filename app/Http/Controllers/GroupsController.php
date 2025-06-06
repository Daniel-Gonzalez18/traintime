<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Group;
class GroupsController extends Controller
{
    public function mostrarGrupos(){
        $user=Auth::user();
        $grupos = $user->groups()->withPivot('role')->get();
        return Inertia::render('Grupo',[
            'grupos'=>$grupos->toArray()
        ]);

    }
    public function store(Request $request){
         $emails = array_map('trim', explode(',', $request->emails));

        $grupo = Group::create([
            'name' => $request->nombre,
            'creator' => auth()->id(),
            'description' => $request->descripcion,
        ]);
        $grupo->users()->attach(auth()->id(), ['role' => 'admin']);
        foreach ($emails as $email) {
            $usuario = User::where('email', $email)->first();
            if ($usuario && $usuario->id !== auth()->id()) {
                $grupo->users()->attach($usuario->id, ['role' => 'member']);
            }
        }
        return redirect()->route('grupo');
    }
}
