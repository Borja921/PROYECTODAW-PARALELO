<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ImportMunicipiosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Ejecuta el comando de importación de forma sincronizada dentro del job
        // Si tu driver de colas es 'sync' se ejecutará inmediatamente; si usas redis/beanstalk se ejecutará en background.
        Artisan::call('municipios:import');
    }
}
