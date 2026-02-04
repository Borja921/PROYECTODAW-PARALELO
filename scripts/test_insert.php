<?php

// bootstrap Laravel application for one-off script
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

try {
    $u = Usuario::create([
        'nombre_apellidos' => 'Usuario Prueba',
        'username' => 'pruebausuario',
        'email' => 'prueba@example.com',
        'fecha_nacimiento' => '1990-05-01',
        'password' => Hash::make('prueba1234'),
    ]);
    echo "Usuario creado id={$u->id}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
