<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function showForm()
    {
        return view('registro');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre_apellidos' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuario,username',
            'email' => 'required|email|max:255|unique:usuario,email',
            'fecha_nacimiento' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // comprobar edad >= 18
        $dob = Carbon::parse($data['fecha_nacimiento']);
        $age = $dob->age;
        if ($age < 18) {
            return back()->withErrors(['fecha_nacimiento' => 'Debes ser mayor de 18 años'])->withInput();
        }

        $usuario = Usuario::create([
            'nombre_apellidos' => $data['nombre_apellidos'],
            'username' => $data['username'],
            'email' => $data['email'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('index')->with('success', 'Registro completado');
    }
}
