<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pruebaPostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\controllerEntrenadores;
use App\Http\Controllers\controllerEquipos;
use App\Http\Controllers\controllerJugadores;
use App\Http\Controllers\controllerSesionesEntrenamiento;
use App\Http\Controllers\controllerParticipaciones;
use App\Models\Entrenador;


//Rutas de Entrenador
Route::post('/register', [controllerEntrenadores::class, 'register']);
Route::post('/login', [controllerEntrenadores::class, 'login']);
Route::get('/perfil', [controllerEntrenadores::class, 'perfil'])->middleware('auth:sanctum');
Route::put('/updateEnt', [controllerEntrenadores::class, 'updateEnt'])->middleware('auth:sanctum');

//Rutas de Equipos
Route::post('/crearEquipo', [controllerEquipos::class, 'crearEquipo']);
Route::post('/verEquipos', [controllerEquipos::class, 'verEquipos']);
Route::post('/eliminarEquipo', [controllerEquipos::class, 'eliminarEquipo']);
Route::post('/nombreEquipo', [controllerEquipos::class, 'nombreEquipo']);

//Rutas de Jugadores
Route::post('/crearJugador', [controllerJugadores::class, 'crearJugador']);
Route::post('/verJugadores', [controllerJugadores::class, 'verJugadores']);
Route::post('/eliminarJugador', [controllerJugadores::class, 'eliminarJugador']);
Route::post('/actualizarJugador',[controllerJugadores::class, 'actualizarJugador']);
Route::post('/perfilJugador', [controllerJugadores::class, 'perfilJugador']);
Route::post('/verTodosJugadores', [controllerJugadores::class, 'verTodosJugadores']);

//Rutas de Sesiones de entrenamiento

Route::post('/crearSesion', [controllerSesionesEntrenamiento::class, 'crearSesion']);
Route::post('/verSesiones', [controllerSesionesEntrenamiento::class, 'verSesiones']);
Route::post('/eliminarSesion', [controllerSesionesEntrenamiento::class, 'eliminarSesion']);
Route::post('/editarSesion', [controllerSesionesEntrenamiento::class, 'editarSesion']);
Route::post('/verTodasSesiones', [controllerSesionesEntrenamiento::class, 'verTodasSesiones']);
//Rutas de Participaciones
Route::post('/crearParticipacion', [controllerParticipaciones::class, 'crearParticipacion']);
Route::post('/verParticipacionesEquipo', [controllerParticipaciones::class, 'verParticipacionesEquipo']);
Route::post('/editarParticipacion', [controllerParticipaciones::class, 'editarParticipacion']);

