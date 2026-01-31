<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
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

        // Manejar redirección específica
        if ($request->filled('redirect_to')) {
            $redirectTo = $request->input('redirect_to');
            if ($redirectTo === 'planes') {
                return redirect()->route('planes')->with('success', 'Has iniciado sesión correctamente');
            }
        }

        // Si viene del modal (referrer es index), redirigir al perfil
        if ($request->header('referer') && str_contains($request->header('referer'), route('index'))) {
            return redirect()->route('perfil')->with('success', 'Has iniciado sesión correctamente');
        }

        return redirect()->route('index')->with('success', 'Has iniciado sesión');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('index')->with('success', 'Sesión cerrada correctamente');
    }
}
