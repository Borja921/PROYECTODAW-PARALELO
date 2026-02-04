<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\MuseumsController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\FestivalsController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PlanWizardController;
use App\Http\Controllers\PerfilController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/destinos', function () {
    return view('destinos');
})->name('destinos');

Route::get('/planes', [App\Http\Controllers\PlanesController::class, 'index'])->name('planes');
Route::post('/planes', [App\Http\Controllers\PlanesController::class, 'store'])->name('planes.store');

Route::get('/mis-planes', [App\Http\Controllers\PlanesController::class, 'myPlans'])->name('mis-planes')->middleware('auth');

// Detalle de plan (ver en perfil)
Route::get('/mis-planes/{id}', [App\Http\Controllers\PlanesController::class, 'show'])->name('mis-planes.show')->middleware('auth');

// Finalizar plan
Route::post('/mis-planes/{id}/finalizar', [App\Http\Controllers\PlanesController::class, 'finalize'])->name('mis-planes.finalize')->middleware('auth');

// Eliminar plan
Route::delete('/mis-planes/{id}', [App\Http\Controllers\PlanesController::class, 'destroy'])->name('mis-planes.destroy')->middleware('auth');

// Marcar/desmarcar como favorito
Route::post('/mis-planes/{id}/toggle-favorite', [App\Http\Controllers\PlanesController::class, 'toggleFavorite'])->name('mis-planes.toggle-favorite')->middleware('auth');

// Legacy route for plan detail (kept for backward compatibility)
Route::get('/planes/{id}', [App\Http\Controllers\PlanesController::class, 'show'])->name('detalle-plan');

Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil')->middleware('auth');
Route::get('/perfil/editar', [App\Http\Controllers\PerfilController::class, 'edit'])->name('perfil.edit')->middleware('auth');
Route::post('/perfil/actualizar', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update')->middleware('auth');
Route::delete('/perfil/eliminar', [App\Http\Controllers\PerfilController::class, 'destroy'])->name('perfil.destroy')->middleware('auth');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::post('/contacto', function () {
    return redirect('/')->with('success', 'Mensaje enviado correctamente');
})->name('contacto.store');

Route::get('/preguntas-frecuentes', function () {
    return view('preguntas-frecuentes');
})->name('preguntas-frecuentes');

Route::get('/registro', [RegistroController::class, 'showForm'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro.store');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/planes/{id}', function ($id) {
    return view('detalle-plan');
})->name('detalle-plan');

Route::get('/hoteles', [HotelsController::class, 'index'])->name('hoteles');
Route::get('/hoteles/filtrar/{locality}', [HotelsController::class, 'filterByLocality'])->name('hotels.filter');
Route::get('/hoteles/{id}', [HotelsController::class, 'show'])->name('hotels.show');

Route::get('/museos', [MuseumsController::class, 'index'])->name('museos');
Route::get('/museos/filtrar/{locality}', [MuseumsController::class, 'filterByLocality'])->name('museums.filter');

Route::get('/restaurantes', [RestaurantsController::class, 'index'])->name('restaurantes');
Route::get('/restaurantes/filtrar/{locality}', [RestaurantsController::class, 'filterByLocality'])->name('restaurants.filter');

Route::get('/fiestas', [FestivalsController::class, 'index'])->name('fiestas');
Route::get('/fiestas/filtrar/{locality}', [FestivalsController::class, 'filterByLocality'])->name('festivals.filter');

// API: municipios (usa cache en el servidor)
Route::get('/api/municipios', [MunicipioController::class, 'index'])->name('api.municipios');
// Forzar refresco/import (POST) - recomendable proteger con middleware auth en producción
Route::post('/api/municipios/refresh', [MunicipioController::class, 'refresh'])->name('api.municipios.refresh');

// Wizard: creación paso a paso de un plan (protegido: requiere login)
Route::middleware('auth')->prefix('plan/wizard')->name('plan.wizard.')->group(function () {
    // Limpiar sesión anterior (iniciar nuevo plan)
    Route::post('/reset', [PlanWizardController::class, 'resetDraft'])->name('reset');
    
    // Paso 1: guardar provincia/municipio/fechas
    Route::post('/step1', [PlanWizardController::class, 'saveStep1'])->name('step1.save');

    // Hoteles (lista y selección)
    Route::get('/hoteles', [PlanWizardController::class, 'hoteles'])->name('hoteles');
    Route::post('/hoteles', [PlanWizardController::class, 'saveHotel'])->name('hoteles.save');

    // Restaurantes
    Route::get('/restaurantes', [PlanWizardController::class, 'restaurantes'])->name('restaurantes');
    Route::post('/restaurantes', [PlanWizardController::class, 'saveRestaurante'])->name('restaurantes.save');

    // Museos
    Route::get('/museos', [PlanWizardController::class, 'museos'])->name('museos');
    Route::post('/museos', [PlanWizardController::class, 'saveMuseo'])->name('museos.save');

    // Fiestas
    Route::get('/fiestas', [PlanWizardController::class, 'fiestas'])->name('fiestas');
    Route::post('/fiestas', [PlanWizardController::class, 'saveFiesta'])->name('fiestas.save');

    // Resumen y finalizar
    Route::get('/summary', [PlanWizardController::class, 'summary'])->name('summary');
    Route::post('/finalize', [PlanWizardController::class, 'finalize'])->name('finalize');
    Route::get('/clear', [PlanWizardController::class, 'clearDraft'])->name('clear');
    Route::post('/remove-item', [PlanWizardController::class, 'removeItem'])->name('remove-item');
});
