<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $ctrl = new \App\Http\Controllers\PlanWizardController();
    echo "PlanWizardController instantiated OK\n";
} catch (\Throwable $e) {
    echo "Error instantiating PlanWizardController: " . $e->getMessage() . "\n";
}
