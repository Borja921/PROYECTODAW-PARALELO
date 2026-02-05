<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistroController extends Controller
{
    public function showForm()
    {
        return view('registro');
    }

    public function register(Request $request)
    {
        $rules = [
            'nombre_apellidos' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuario,username',
            'email' => 'required|email|max:255|unique:usuario,email',
            'fecha_nacimiento' => 'required|date',
            'hospedaje_favorito' => 'nullable|string|max:255|in:hotel,apartamento,hostal',
            'tipo_comida' => 'nullable|string|max:255|in:tradicional,internacional,vegetariana',
            'actividades' => 'nullable|string|max:255|in:museos,naturaleza,aventura',
            'tipo_viaje' => 'nullable|string|max:255|in:pareja,familia,amigos',
            'password' => 'required|string|min:8|confirmed',
        ];

        $messages = [
            'email.email' => 'El correo electrónico debe tener un formato válido (ejemplo: correo@ejemplo.com).',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Validación adicional: edad >= 18
        $validator->after(function ($validator) use ($request) {
            if ($request->filled('fecha_nacimiento')) {
                try {
                    $dob = Carbon::parse($request->input('fecha_nacimiento'));
                    if ($dob->age < 18) {
                        $validator->errors()->add('fecha_nacimiento', 'Debes ser mayor o igual a 18 años.');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('fecha_nacimiento', 'La fecha de nacimiento no es válida.');
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $usuario = Usuario::create([
            'nombre_apellidos' => $data['nombre_apellidos'],
            'username' => $data['username'],
            'email' => $data['email'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'hospedaje_favorito' => $data['hospedaje_favorito'] ?? null,
            'tipo_comida' => $data['tipo_comida'] ?? null,
            'actividades' => $data['actividades'] ?? null,
            'tipo_viaje' => $data['tipo_viaje'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('index')->with('success', 'Registro completado');
    }
}
