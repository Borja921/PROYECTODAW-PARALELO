<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
        
        // Planes favoritos
        $planesFavoritos = Plan::where($userColumn, $user->id)
            ->where('is_favorite', true)
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
            'sitiosVisitados' => $sitiosVisitados,
            'planesFavoritos' => $planesFavoritos
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
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('usuario', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuario', 'email')->ignore($user->id),
            ],
            'fecha_nacimiento' => 'nullable|date',
            'hospedaje_favorito' => 'nullable|string|max:255',
            'tipo_comida' => 'nullable|string|max:255',
            'actividades' => 'nullable|string|max:255',
            'tipo_viaje' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->nombre_apellidos = $request->nombre_apellidos;
        $user->username = $request->username;
        $user->email = $request->email;
        
        if ($request->fecha_nacimiento) {
            $user->fecha_nacimiento = $request->fecha_nacimiento;
        }

        $user->hospedaje_favorito = $request->hospedaje_favorito;
        $user->tipo_comida = $request->tipo_comida;
        $user->actividades = $request->actividades;
        $user->tipo_viaje = $request->tipo_viaje;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Eliminar la cuenta del usuario autenticado
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('index')->with('success', 'Cuenta eliminada correctamente.');
    }
}
