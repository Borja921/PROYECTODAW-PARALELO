<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        $mapping = Cache::remember('jcyl_municipios_v1', 60 * 24, function () {
            $rows = Municipio::select('provincia', 'municipio')
                ->orderBy('provincia')
                ->orderBy('municipio')
                ->get();

            $map = [];
            foreach ($rows as $r) {
                $prov = $r->provincia;
                if (!isset($map[$prov])) $map[$prov] = [];
                $map[$prov][] = $r->municipio;
            }
            return $map;
        });

        return response()->json($mapping);
    }

    /**
     * Forzar refresco: limpia cache y lanza job de import (requiere permisos en prod).
     */
    public function refresh(Request $request)
    {
        // Nota: este endpoint no está protegido por auth en esta PR; puedes añadir middleware 'auth' si lo deseas.
        Cache::forget('jcyl_municipios_v1');

        // Dispatch job para reimportar (se ejecuta en background si queue driver está configurado)
        \App\Jobs\ImportMunicipiosJob::dispatch();

        return response()->json(['status' => 'refresh_started'], 202);
    }
}
