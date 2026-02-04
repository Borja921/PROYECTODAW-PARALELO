<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;

try {
    $req = Request::create('/login', 'POST', [
        'login' => 'pruebausuario',
        'password' => 'prueba1234',
    ]);

    $ctrl = new LoginController();
    $resp = $ctrl->login($req);

    // comprueba si la sesión está autenticada mediante el guard de Laravel
    $uid = auth()->id();
    if ($uid) {
        echo "Login OK, user_id={$uid}\n";
    } else {
        echo "Login fallido, no hay usuario autenticado.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
