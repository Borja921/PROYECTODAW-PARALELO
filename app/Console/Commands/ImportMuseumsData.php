<?php

namespace App\Console\Commands;

use App\Models\PublicMuseum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class ImportMuseumsData extends Command
{
    protected $signature = 'museums:import {--local : Usar archivo CSV local descargado manualmente}';
    protected $description = 'Importa datos de museos desde el CSV oficial';

    public function handle()
    {
        $tempFile = storage_path('temp_museums.csv');
        
        // Si se usa opción --local, buscar archivo ya descargado
        if ($this->option('local')) {
            if (!file_exists($tempFile)) {
                $this->error("Archivo no encontrado en: $tempFile");
                $this->info("Por favor, descarga el CSV desde:");
                $this->info("https://datosabiertos.jcyl.es/web/jcyl/risp/es/cultura-ocio/museos/1284197401971.csv");
                $this->info("Y guárdalo en: $tempFile");
                return 1;
            }
            $this->info('Usando archivo local...');
            $content = file_get_contents($tempFile);
        } else {
            $this->info('Descargando datos de museos...');
            
            try {
                // Descargar el CSV con SSL verify deshabilitado
                $csvUrl = 'https://datosabiertos.jcyl.es/web/jcyl/risp/es/cultura-ocio/museos/1284197401971.csv';
                
                $response = Http::timeout(120)->retry(3, 100)->withoutVerifying()->get($csvUrl);

                if (!$response->successful()) {
                    $this->error('No se pudo descargar el archivo CSV');
                    $this->info("\nPrueba descargarlo manualmente y ejecuta:");
                    $this->info("php artisan museums:import --local");
                    return 1;
                }

                $content = $response->body();
                file_put_contents($tempFile, $content);
            } catch (\Exception $e) {
                $this->error('Error durante la descarga: ' . $e->getMessage());
                $this->info("\nPrueba descargarlo manualmente desde:");
                $this->info("https://datosabiertos.jcyl.es/web/jcyl/risp/es/cultura-ocio/museos/1284197401971.csv");
                $this->info("Guárdalo en: $tempFile");
                $this->info("Y ejecuta: php artisan museums:import --local");
                return 1;
            }
        }
        
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
        $showStructure = true;

        foreach ($records as $record) {
            try {
                $rowNum++;

                // Detectar y saltar encabezado
                if ($skipHeader && isset($record[0])) {
                    if ($this->isHeader($record)) {
                        $this->info("✓ Encabezado detectado: " . count($record) . " columnas");
                        $this->line("Estructura completa:");
                        foreach ($record as $i => $col) {
                            $this->line("  [$i] $col");
                        }
                        $skipHeader = false;
                        $showStructure = false;
                        continue;
                    }
                }
                $skipHeader = false;

                // Mostrar primeros registros para debugging
                if ($showStructure && $rowNum < 3) {
                    $this->error("\nPrimer registro (fila $rowNum):");
                    foreach ($record as $i => $val) {
                        $this->line("  [$i] " . substr($val, 0, 50));
                    }
                }

                // Mapear registro
                $museumData = $this->mapRecord($record);

                if (!$museumData) {
                    $errors++;
                    if ($errors <= 3) {
                        $this->warn("Registro $rowNum descartado - datos insuficientes");
                    }
                    continue;
                }

                // Crear o actualizar
                PublicMuseum::updateOrCreate(
                    ['name' => $museumData['name'], 'locality' => $museumData['locality']],
                    $museumData
                );

                $imported++;

                if ($imported % 50 === 0) {
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
    }
    
    /**
     * Obtener provincia basada en localidad
     */
    private function getProvinceByLocality($locality)
    {
        // Mapeo de localidades a provincias de Castilla y León
        $localityMap = [
            // Ávila
            'ávila' => 'Ávila',
            'arenas de san pedro' => 'Ávila',
            'el barco de ávila' => 'Ávila',
            'el tiemblo' => 'Ávila',
            'oropesa' => 'Ávila',
            'piedrahita' => 'Ávila',
            'navaluenga' => 'Ávila',
            
            // Burgos
            'burgos' => 'Burgos',
            'aranda de duero' => 'Burgos',
            'miranda de ebro' => 'Burgos',
            'briviesca' => 'Burgos',
            'castrojeriz' => 'Burgos',
            
            // Cuenca
            'cuenca' => 'Cuenca',
            'tarancón' => 'Cuenca',
            'serranía de cuenca' => 'Cuenca',
            'huete' => 'Cuenca',
            
            // Guadalajara
            'guadalajara' => 'Guadalajara',
            'azuqueca de henares' => 'Guadalajara',
            'alcalá de henares' => 'Guadalajara',
            'molina de aragón' => 'Guadalajara',
            
            // León
            'león' => 'León',
            'ponferrada' => 'León',
            'astorga' => 'León',
            'la bañeza' => 'León',
            'bembibre' => 'León',
            'san andrés del rabanedo' => 'León',
            
            // Palencia
            'palencia' => 'Palencia',
            'cervera de pisuerga' => 'Palencia',
            'dueñas' => 'Palencia',
            'aguilar de campoo' => 'Palencia',
            
            // Salamanca
            'salamanca' => 'Salamanca',
            'ciudad rodrigo' => 'Salamanca',
            'alba de tormes' => 'Salamanca',
            'béjar' => 'Salamanca',
            'peñaranda de bracamonte' => 'Salamanca',
            
            // Segovia
            'segovia' => 'Segovia',
            'sepúlveda' => 'Segovia',
            'pedraza' => 'Segovia',
            'santa maría la real de nieva' => 'Segovia',
            'cuéllar' => 'Segovia',
            
            // Soria
            'soria' => 'Soria',
            'medinaceli' => 'Soria',
            'almazán' => 'Soria',
            'osma' => 'Soria',
            
            // Valladolid
            'valladolid' => 'Valladolid',
            'medina del campo' => 'Valladolid',
            'medina de rioseco' => 'Valladolid',
            'tordesillas' => 'Valladolid',
            'olmedo' => 'Valladolid',
            'peñafiel' => 'Valladolid',
            
            // Zamora
            'zamora' => 'Zamora',
            'toro' => 'Zamora',
            'alcañices' => 'Zamora',
            'vejezate' => 'Zamora',
        ];

        // Buscar la localidad en el mapa (case-insensitive)
        $localityLower = strtolower(trim($locality));
        
        foreach ($localityMap as $key => $province) {
            if (strpos($localityLower, $key) !== false || $key === $localityLower) {
                return $province;
            }
        }

        return false;
    }

    /**
     * Detectar si es una fila de encabezado
     */
    private function isHeader($record)
    {
        // Buscar palabras clave específicas del encabezado de museos
        $headerKeywords = ['NombreEntidad', 'DescripcionBlob', 'Localidad', 'Horario'];
        $firstVal = $record[0] ?? '';
        
        // Si contiene "DescripcionBlob" en la primera columna, es el encabezado real
        if (strpos($firstVal, 'DescripcionBlob') !== false || 
            strpos($firstVal, 'Fichero actualizado') !== false ||
            strpos($firstVal, 'Nombre') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Mapear registro a estructura de museo
     */
    private function mapRecord($record)
    {
        if (!is_array($record) || empty($record)) {
            return null;
        }

        // Limpiar valores
        $record = array_map(fn($v) => trim($v ?? ''), $record);

        // Mapeo según estructura real del CSV de museos:
        // [0] DescripcionBlob, [1] NombreEntidad, [5] Localidad, [8] Tipo de Gestión
        // [9] Horario de apertura, [12] Servicios, [13] Información adicional, [19] Enlace
        
        // Asegurarse de que tenemos al menos nombre y localidad
        $name = trim($record[1] ?? $record[0] ?? '');
        $locality = trim($record[5] ?? $record[6] ?? '');

        if (empty($name) || empty($locality)) {
            return null;
        }

        $description = trim($record[0] ?? '');
        $additionalInfo = trim($record[13] ?? '');
        $fullDescription = trim($description . ' ' . $additionalInfo);

        $museumData = [
            'name' => $name,
            'locality' => $locality,
            'province' => $this->normalizeProvince('Castilla y León'), // Por defecto
            'address' => '', 
            'postal_code' => '',
            'phone' => '',
            'email' => '',
            'website' => trim($record[19] ?? ''),
            'museum_type' => trim($record[8] ?? 'Museo'),
            'description' => !empty($fullDescription) ? $fullDescription : null,
            'opening_hours' => trim($record[9] ?? ''),
            'amenities' => !empty($record[12]) ? json_encode(array_map('trim', explode(',', $record[12]))) : null,
            'is_active' => true,
            'source' => 'opendata',
            'rating' => 4.0,
        ];

        return $museumData;
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
