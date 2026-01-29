<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Usuario::where('username', $data['login'])
            ->orWhere('email', $data['login'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['login' => 'Credenciales inválidas'])->withInput();
        }

        // Guardar en sesión el id del usuario
        session()->put('usuario_id', $user->id);

        return redirect()->route('index')->with('success', 'Has iniciado sesión');
    }

    public function logout()
    {
        session()->forget('usuario_id');
        return redirect()->route('index')->with('success', 'Sesión cerrada');
    }
}
