<?php

namespace App\Console\Commands;

use App\Models\PublicFestival;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class ImportFestivalsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'festivals:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar datos públicos de fiestas locales desde CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Descargando datos de fiestas locales...');

            // Descargar el CSV
            $response = Http::withoutVerifying()->get('https://datosabiertos.jcyl.es/web/jcyl/risp/es/empleo/fiestas-locales/1284952783683-3.csv');

            if (!$response->successful()) {
                $this->error('Error descargando el archivo CSV');
                return 1;
            }

            // Guardar en archivo temporal
            $tempFile = tempnam(sys_get_temp_dir(), 'festivals_');
            $content = $response->body();
            
            // Remover BOM UTF-8 si existe
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }
            
            file_put_contents($tempFile, $content);

            // Leer el CSV
            $csv = Reader::createFromPath($tempFile, 'r');
            $csv->setDelimiter(';');
            $csv->setEnclosure('"');

            $records = $csv->getRecords();
            
            $imported = 0;
            $errors = 0;
            $rowNum = 0;

            foreach ($records as $record) {
                $rowNum++;

                // Saltar encabezado
                if ($this->isHeader($record)) {
                    continue;
                }

                try {
                    // Mapear registro
                    $festivalData = $this->mapRecord($record);

                    if (!$festivalData) {
                        $errors++;
                        if ($errors <= 3) {
                            $this->warn("Registro $rowNum descartado - datos insuficientes");
                        }
                        continue;
                    }

                    // Crear o actualizar
                    PublicFestival::updateOrCreate(
                        ['name' => $festivalData['name'], 'locality' => $festivalData['locality'], 'start_date' => $festivalData['start_date']],
                        $festivalData
                    );

                    $imported++;

                    if ($imported % 100 === 0) {
                        $this->info("✓ Importados: $imported registros...");
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
     * Detectar si es una fila de encabezado
     */
    private function isHeader($record)
    {
        $headerKeywords = ['Provincia', 'Municipio', 'Fecha fiesta', 'Nombre fiesta'];
        $firstVal = $record[0] ?? '';
        
        if (strpos($firstVal, 'Provincia') !== false || 
            strpos($firstVal, 'Fichero actualizado') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Mapear registro a estructura de fiesta
     */
    private function mapRecord($record)
    {
        if (!is_array($record) || empty($record)) {
            return null;
        }

        // Limpiar valores
        $record = array_map(fn($v) => trim($v ?? ''), $record);
        
        // Convertir encoding a UTF-8
        $record = array_map(function($v) {
            if (mb_detect_encoding($v, 'UTF-8', true) === false) {
                $v = mb_convert_encoding($v, 'UTF-8', 'ISO-8859-1');
            }
            return $v;
        }, $record);

        // Estructura del CSV de fiestas (5 columnas):
        // [0] = Provincia
        // [1] = Municipio (Localidad)
        // [2] = Fecha fiesta (DD/MM/YYYY)
        // [3] = Nombre fiesta
        // [4] = INE (código)
        
        $province = trim($record[0] ?? '');
        $locality = trim($record[1] ?? '');
        $dateStr = trim($record[2] ?? '');
        $name = trim($record[3] ?? '');

        if (empty($name) || empty($locality) || empty($province)) {
            return null;
        }

        // Parsear fecha
        $startDate = null;
        if (!empty($dateStr)) {
            try {
                // Formato DD/MM/YYYY
                $dateParts = explode('/', $dateStr);
                if (count($dateParts) === 3) {
                    $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dateStr)->startOfDay();
                }
            } catch (\Exception $e) {
                // Si no se puede parsear, usar null
            }
        }

        $festivalData = [
            'name' => $name,
            'locality' => $locality,
            'province' => $this->normalizeProvince($province),
            'start_date' => $startDate,
            'end_date' => null, // No disponible en CSV
            'festival_type' => 'Fiesta Local', // Genérico
            'address' => null, // No disponible
            'postal_code' => null, // No disponible
            'phone' => null, // No disponible
            'email' => null, // No disponible
            'website' => null, // No disponible
            'price' => null, // No disponible
            'time' => null, // No disponible
            'description' => null, // No disponible
            'is_active' => true,
            'source' => 'opendata',
            'rating' => 4.0,
        ];

        return $festivalData;
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
