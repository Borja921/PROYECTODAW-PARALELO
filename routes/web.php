<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\MuseumsController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\FestivalsController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MunicipioController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/destinos', function () {
    return view('destinos');
})->name('destinos');

Route::get('/planes', [App\Http\Controllers\PlanesController::class, 'index'])->name('planes');
Route::post('/planes', [App\Http\Controllers\PlanesController::class, 'store'])->name('planes.store');

Route::get('/mis-planes', function () {
    return view('mis-planes');
})->name('mis-planes');

Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

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
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

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
