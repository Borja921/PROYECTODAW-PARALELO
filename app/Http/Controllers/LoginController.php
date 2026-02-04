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

        // Autenticar usando el sistema de Laravel y opcionalmente 'remember'
        $remember = $request->filled('remember');
        auth()->login($user, $remember);

        return redirect()->route('index')->with('success', 'Has iniciado sesión');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('index')->with('success', 'Sesión cerrada');
    }
}
