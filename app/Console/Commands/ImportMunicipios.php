<?php

namespace App\Console\Commands;

use App\Models\Municipio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ImportMunicipios extends Command
{
    protected $signature = 'municipios:import';
    protected $description = 'Importa municipios desde el CSV oficial de la Junta de Castilla y León';

    public function handle()
    {
        $this->info('Descargando CSV de municipios...');

        $csvUrl = 'https://opendata.jcyl.es/ficheros/atel/MunicipiosJCyL.csv';

        try {
            $response = Http::timeout(60)->withoutVerifying()->get($csvUrl);
            if (!$response->ok()) {
                $this->error('No se pudo descargar el CSV. Código: ' . $response->status());
                return 1;
            }

            $content = $response->body();
            // eliminar BOM si existe
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }

            // Detectar codificación y convertir a UTF-8 si es necesario (evita errores en MySQL)
            $detected = mb_detect_encoding($content, ['UTF-8','ISO-8859-1','WINDOWS-1252'], true);
            if ($detected && strtoupper($detected) !== 'UTF-8') {
                $content = mb_convert_encoding($content, 'UTF-8', $detected);
            }
            // Eliminar caracteres inválidos dejados por conversiones imperfectas
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);

            // detectar separador: si contiene ';' es probable que sea ';' sino ','
            $firstLine = strtok($content, "\n");
            $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

            $lines = array_filter(preg_split('/\r?\n/', trim($content)));
            if (count($lines) < 2) {
                $this->error('CSV vacío o con formato inesperado');
                return 1;
            }

            // cabeceras
            $headers = str_getcsv(array_shift($lines), $delimiter);
            $headersLow = array_map(fn($h) => mb_strtolower(trim($h)), $headers);

            // detectar índices
            $provCandidates = ['provincia', 'provincia_nombre', 'provincia_ine', 'prov'];
            $munCandidates = ['municipio', 'nombre', 'nombre_municipio', 'municipio_nombre', 'municipio_ine', 'nombre municipio'];

            $pIdx = $this->findIndex($headersLow, $provCandidates);
            $mIdx = $this->findIndex($headersLow, $munCandidates);

            if ($pIdx === -1 || $mIdx === -1) {
                $this->error('No se pudieron detectar las columnas de provincia/municipio en el CSV');
                return 1;
            }

            $batch = [];
            $imported = 0;
            foreach ($lines as $line) {
                $row = str_getcsv($line, $delimiter);
                $prov = trim($row[$pIdx] ?? '');
                $mun = trim($row[$mIdx] ?? '');
                if (empty($prov) || empty($mun)) continue;

                $batch[] = [
                    'provincia' => $prov,
                    'municipio' => $mun,
                    'source' => 'opendata',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($batch) >= 500) {
                    Municipio::upsert($batch, ['provincia', 'municipio']);
                    $imported += count($batch);
                    $this->info("Importados: $imported");
                    $batch = [];
                }
            }

            if (count($batch) > 0) {
                Municipio::upsert($batch, ['provincia', 'municipio']);
                $imported += count($batch);
            }

            $this->info("✅ Importación completada. Registros procesados: $imported");
            return 0;
        } catch (\Exception $e) {
            $this->error('Error durante la importación: ' . $e->getMessage());
            return 1;
        }
    }

    private function findIndex(array $headersLow, array $candidates)
    {
        foreach ($candidates as $c) {
            $idx = array_search(mb_strtolower($c), $headersLow);
            if ($idx !== false) return $idx;
        }
        return -1;
    }
}
