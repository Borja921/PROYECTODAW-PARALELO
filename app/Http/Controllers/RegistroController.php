<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistroController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'nombre_apellidos' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuario,username',
            'email' => 'required|email|max:255|unique:usuario,email',
            'fecha_nacimiento' => 'required|date',
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
            'password' => Hash::make($data['password']),
        ]);

        // Autenticar automáticamente al usuario después del registro
        auth()->login($usuario);

        return redirect()->route('perfil')->with('success', 'Registro completado correctamente. ¡Bienvenido!');
    }
}
