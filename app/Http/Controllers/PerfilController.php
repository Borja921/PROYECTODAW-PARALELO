<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil del usuario autenticado
     */
    public function index()
    {
        $user = Auth::user();
        
        $userColumn = Plan::userColumn();

        // Obtener estadísticas del usuario
        $planesGuardados = Plan::where($userColumn, $user->id)->count();
        
        // Planes finalizados (status = 'completado')
        $planesFinalizados = Plan::where($userColumn, $user->id)
            ->where('status', 'completado')
            ->count();
        
        // Calcular sitios visitados (suma de items en todos los planes)
        $sitiosVisitados = 0;
        $planes = Plan::where($userColumn, $user->id)->get();
        foreach ($planes as $plan) {
            if (is_array($plan->items)) {
                $sitiosVisitados += count($plan->items);
            }
        }
        
        return view('perfil', [
            'user' => $user,
            'planesGuardados' => $planesGuardados,
            'planesFinalizados' => $planesFinalizados,
            'sitiosVisitados' => $sitiosVisitados
        ]);
    }

    /**
     * Mostrar el formulario de edición del perfil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('perfil-editar', ['user' => $user]);
    }

    /**
     * Actualizar el perfil del usuario
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombre_apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email,' . $user->id . ',id',
            'fecha_nacimiento' => 'nullable|date',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->nombre_apellidos = $request->nombre_apellidos;
        $user->email = $request->email;
        
        if ($request->fecha_nacimiento) {
            $user->fecha_nacimiento = $request->fecha_nacimiento;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
