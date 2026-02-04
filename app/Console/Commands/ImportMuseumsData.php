<?php

namespace App\Console\Commands;

use App\Models\PublicMuseum;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ImportMuseumsData extends Command
{
    protected $signature = 'museums:import';
    protected $description = 'Importa datos de museos desde el CSV oficial';

    public function handle()
    {
        $this->info('Descargando datos de museos...');

        try {
            $csvUrl = 'https://datosabiertos.jcyl.es/web/jcyl/risp/es/cultura-ocio/museos/1284197401971.csv';

            // 🔥 DESCARGA DEFINITIVA (SIN cURL)
            $content = $this->downloadCsvWithoutCurl($csvUrl);

            if (!$content) {
                $this->error('No se pudo descargar el archivo CSV');
                return 1;
            }

            // 🔥 Detectar y convertir encoding REAL
            $encoding = mb_detect_encoding(
                $content,
                ['UTF-8', 'ISO-8859-1', 'Windows-1252'],
                true
            ) ?: 'ISO-8859-1';

            $content = mb_convert_encoding($content, 'UTF-8', $encoding);

            // Eliminar BOM UTF-8
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }

            // Guardar temporal
            $tempFile = storage_path('temp_museums.csv');
            file_put_contents($tempFile, $content);

            // Leer CSV
            $csv = Reader::createFromPath($tempFile, 'r');
            $csv->setDelimiter(';');
            $csv->setEnclosure('"');

            $records = $csv->getRecords();

            $imported = 0;
            $errors = 0;
            $rowNum = 0;
            $skipHeader = true;

            foreach ($records as $record) {
                $rowNum++;

                try {
                    // Saltar encabezado
                    if ($skipHeader && $this->isHeader($record)) {
                        $this->info("✓ Encabezado detectado (" . count($record) . " columnas)");
                        $skipHeader = false;
                        continue;
                    }
                    $skipHeader = false;

                    $museumData = $this->mapRecord($record);

                    if (!$museumData) {
                        $errors++;
                        continue;
                    }

                    PublicMuseum::updateOrCreate(
                        [
                            'name' => $museumData['name'],
                            'locality' => $museumData['locality'],
                        ],
                        $museumData
                    );

                    $imported++;

                    if ($imported % 50 === 0) {
                        $this->line("✓ Importados: $imported registros...");
                    }
                } catch (\Throwable $e) {
                    $errors++;
                    if ($errors <= 3) {
                        $this->error("Error en fila $rowNum: " . $e->getMessage());
                    }
                }
            }

            @unlink($tempFile);

            $this->info("\n✅ Importación completada");
            $this->info("📊 Registros importados: $imported");
            if ($errors > 0) {
                $this->warn("⚠️ Registros con error: $errors");
            }

            return 0;
        } catch (\Throwable $e) {
            $this->error('Error durante la importación: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * 🔥 Descarga SIN cURL (SSL roto friendly)
     */
    private function downloadCsvWithoutCurl(string $url): ?string
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
            'http' => [
                'timeout' => 60,
            ],
        ]);

        $content = @file_get_contents($url, false, $context);

        return ($content !== false && strlen($content) > 100)
            ? $content
            : null;
    }

    /**
     * Detectar encabezado
     */
    private function isHeader(array $record): bool
    {
        $firstVal = $record[0] ?? '';

        return
            str_contains($firstVal, 'DescripcionBlob') ||
            str_contains($firstVal, 'Fichero actualizado') ||
            str_contains($firstVal, 'NombreEntidad');
    }

    /**
     * Mapear fila CSV
     */
    private function mapRecord(array $record): ?array
    {
        $record = array_map(fn($v) => trim($v ?? ''), $record);

        $name = trim($record[1] ?? '');
        $locality = trim($record[5] ?? '');

        if ($name === '' || $locality === '') {
            return null;
        }

        $description = trim($record[0] ?? '');
        $additionalInfo = trim($record[13] ?? '');

        return [
            'name' => $name,
            'locality' => $locality,
            'province' => 'Castilla y León',
            'address' => '',
            'postal_code' => '',
            'phone' => '',
            'email' => '',
            'website' => trim($record[19] ?? ''),
            'museum_type' => trim($record[8] ?? 'Museo'),
            'description' => trim($description . ' ' . $additionalInfo),
            'opening_hours' => trim($record[9] ?? ''),
            'amenities' => !empty($record[12])
                ? json_encode(array_map('trim', explode(',', $record[12])), JSON_UNESCAPED_UNICODE)
                : null,
            'is_active' => true,
            'source' => 'opendata',
            'rating' => 4.0,
        ];
    }
}
