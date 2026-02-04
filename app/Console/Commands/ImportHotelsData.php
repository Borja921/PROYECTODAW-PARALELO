<?php

namespace App\Console\Commands;

use App\Models\PublicHotel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class ImportHotelsData extends Command
{
    protected $signature = 'hotels:import';
    protected $description = 'Importa datos de alojamientos hoteleros desde el CSV oficial';

    public function handle()
    {
        $this->info('Descargando datos de alojamientos hoteleros...');

        try {
            // Descargar el CSV con SSL verify deshabilitado para desarrollo local
            $csvUrl = 'https://opendata.jcyl.es/ficheros/cct/retu/alojamientoshoteleros.csv';
            
            $response = Http::timeout(30)->withoutVerifying()->get($csvUrl);

            if (!$response->successful()) {
                $this->error('No se pudo descargar el archivo CSV');
                return 1;
            }

            // Guardar temporalmente y fijar encoding
            $tempFile = storage_path('temp_hotels.csv');
            $content = $response->body();
            
            // Eliminar BOM UTF-8 si existe
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }
            
            // Fijar codificación
            $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
            file_put_contents($tempFile, $content);

            // Procesar CSV
            $csv = Reader::createFromPath($tempFile, 'r');
            $csv->setDelimiter(';');
            $csv->setEnclosure('"');
            
            $records = $csv->getRecords();
            $imported = 0;
            $errors = 0;
            $rowNum = 0;
            $skipHeader = true;

            foreach ($records as $record) {
                try {
                    $rowNum++;

                    // Saltar primera fila (encabezado)
                    if ($skipHeader && isset($record[0]) && strpos($record[0], 'N.Registro') !== false) {
                        $this->info("✓ Encabezado detectado y saltado");
                        $skipHeader = false;
                        continue;
                    }
                    $skipHeader = false;

                    // Mapeo correcto según estructura real del CSV (23 columnas)
                    // 0: N.Registro, 1: Tipo, 2: Categoría, 3: Especialidades, 4: Nombre
                    // 5: Dirección, 6: C.Postal, 7: Provincia, 8: Municipio, 9: Teléfono 1
                    
                    $hotelData = [
                        'name' => trim($record[4] ?? ''),
                        'locality' => trim($record[8] ?? ''),
                        'province' => $this->normalizeProvince(trim($record[7] ?? '')),
                        'address' => trim($record[5] ?? ''),
                        'postal_code' => trim($record[6] ?? ''),
                        'phone' => trim($record[9] ?? ''),
                        'email' => trim($record[10] ?? ''),
                        'website' => trim($record[11] ?? ''),
                        'classification' => trim($record[2] ?? ''),
                        'description' => trim($record[3] ?? ''),
                        'is_active' => true,
                        'source' => 'opendata',
                        'rating' => 4.0,
                    ];

                    // Validar datos mínimos
                    if (empty($hotelData['name']) || empty($hotelData['locality'])) {
                        $errors++;
                        continue;
                    }

                    // Crear o actualizar
                    PublicHotel::updateOrCreate(
                        ['name' => $hotelData['name'], 'locality' => $hotelData['locality']],
                        $hotelData
                    );

                    $imported++;

                    if ($imported % 100 === 0) {
                        $this->line("✓ Importados: $imported registros...");
                    }
                } catch (\Exception $e) {
                    $errors++;
                    if ($errors <= 3) {
                        $this->error("Error en fila $rowNum: " . $e->getMessage());
                    }
                }
            }

            // Limpiar archivo temporal
            @unlink($tempFile);

            $this->info("\n✅ Importación completada!");
            $this->info("📊 Registros importados: $imported");
            if ($errors > 0) {
                $this->warn("⚠️ Registros con error: $errors");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Error durante la importación: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Normaliza nombres de provincias corrigiendo caracteres mal codificados
     */
    private function normalizeProvince(string $province): string
    {
        // Correcciones para provincias con caracteres mal codificados
        $corrections = [
            '?vila' => 'Ávila',
            'Le?n' => 'León',
        ];

        return $corrections[$province] ?? $province;
    }
}
