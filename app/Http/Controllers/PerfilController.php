<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Plan;
use App\Http\Requests\UpdatePerfilRequest;

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
    public function update(UpdatePerfilRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $user->nombre_apellidos = $validated['nombre_apellidos'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        
        if ($validated['fecha_nacimiento'] ?? null) {
            $user->fecha_nacimiento = $validated['fecha_nacimiento'];
        }

        $user->hospedaje_favorito = $validated['hospedaje_favorito'] ?? null;
        $user->tipo_comida = $validated['tipo_comida'] ?? null;
        $user->actividades = $validated['actividades'] ?? null;
        $user->tipo_viaje = $validated['tipo_viaje'] ?? null;

        if ($validated['password'] ?? null) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $fileName = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('img/profiles');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $file->move($destination, $fileName);

            if ($user->profile_photo && str_starts_with($user->profile_photo, 'img/profiles/')) {
                $oldPath = public_path($user->profile_photo);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $user->profile_photo = 'img/profiles/' . $fileName;
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
        $userColumn = Plan::userColumn();

        Plan::where($userColumn, $user->id)->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('index')->with('success', 'Cuenta eliminada correctamente.');
    }
}
