<?php

namespace App\Console\Commands;

use App\Models\PublicRestaurant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class ImportRestaurantsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restaurants:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar datos públicos de restaurantes desde CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Descargando datos de restaurantes...');

            // Descargar el CSV
            $response = Http::withoutVerifying()->get('https://datosabiertos.jcyl.es/web/jcyl/risp/es/turismo/restaurantes/1284211839594.csv');

            if (!$response->successful()) {
                $this->error('Error descargando el archivo CSV');
                return 1;
            }

            // Guardar en archivo temporal
            $tempFile = tempnam(sys_get_temp_dir(), 'restaurants_');
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
                    $restaurantData = $this->mapRecord($record);

                    if (!$restaurantData) {
                        $errors++;
                        if ($errors <= 3) {
                            $this->warn("Registro $rowNum descartado - datos insuficientes");
                        }
                        continue;
                    }

                    // Crear o actualizar
                    PublicRestaurant::updateOrCreate(
                        ['name' => $restaurantData['name'], 'locality' => $restaurantData['locality']],
                        $restaurantData
                    );

                    $imported++;

                    if ($imported % 50 === 0) {
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
        $headerKeywords = ['Nombre', 'Localidad', 'Provincia', 'Dirección'];
        $firstVal = $record[0] ?? '';
        
        if (strpos($firstVal, 'Nombre') !== false || 
            strpos($firstVal, 'Fichero actualizado') !== false ||
            strpos($firstVal, 'CódigoEntidad') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Mapear registro a estructura de restaurante
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

        // Estructura del CSV de restaurantes (22 columnas):
        // [4] = Nombre (restaurant name)
        // [9] = Localidad (locality)
        // [7] = Provincia (province)
        // [5] = Dirección (address)
        // [6] = C.Postal (postal code)
        // [11] = Teléfono 1 (phone)
        // [14] = Email
        // [15] = web (website)
        // [3] = Especialidades (cuisine type)
        // [2] = Categoría (price level)
        
        $name = trim($record[4] ?? '');
        $locality = trim($record[9] ?? '');
        $province = trim($record[7] ?? '');

        if (empty($name) || empty($locality)) {
            return null;
        }

        $restaurantData = [
            'name' => $name,
            'locality' => $locality,
            'province' => !empty($province) ? $province : 'Castilla y León',
            'address' => trim($record[5] ?? ''),
            'postal_code' => trim($record[6] ?? ''),
            'phone' => trim($record[11] ?? ''),
            'email' => trim($record[14] ?? ''),
            'website' => trim($record[15] ?? ''),
            'cuisine_type' => trim($record[3] ?? ''),
            'price_level' => trim($record[2] ?? ''),
            'opening_hours' => '', // No disponible en el CSV
            'description' => '', // No disponible en el CSV
            'is_active' => true,
            'source' => 'opendata',
            'rating' => 4.0,
        ];

        return $restaurantData;
    }
}
