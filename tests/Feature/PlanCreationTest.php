<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanCreationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('pdo_sqlite extension is required to run these DB tests locally.');
        }
    }

    public function test_store_rejects_invalid_date_range()
    {
        // preparar provincia/municipio
        DB::table('municipios')->insert([
            'provincia' => 'TestProv',
            'municipio' => 'TestMun',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post('/plans', [
            'provincia' => 'TestProv',
            'municipio' => 'TestMun',
            'start_date' => Carbon::today()->addDays(5)->format('Y-m-d'),
            'end_date' => Carbon::today()->addDays(2)->format('Y-m-d'), // end < start
        ]);

        $response->assertSessionHasErrors(['end_date']);
    }

    public function test_store_creates_plan_with_valid_data()
    {
        DB::table('municipios')->insert([
            'provincia' => 'TestProv2',
            'municipio' => 'TestMun2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $start = Carbon::today()->addDays(1);
        $end = Carbon::today()->addDays(3);

        $response = $this->post('/plans', [
            'provincia' => 'TestProv2',
            'municipio' => 'TestMun2',
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'items' => json_encode([['nombre' => 'Lugar 1'], ['nombre' => 'Lugar 2']]),
        ]);

        $response->assertRedirect('/planes');
        $this->assertDatabaseHas('plans', [
            'provincia' => 'TestProv2',
            'municipio' => 'TestMun2',
            'days' => 3,
        ]);
    }
}
