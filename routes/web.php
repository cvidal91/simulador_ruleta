<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'JuegoController@index');
Route::get('jugador/', 'Admin\JugadorController@consultarJugadores');
Route::get('jugador/registro', 'Admin\JugadorController@mostrarRegistrar');
Route::get('jugador/editar/{id_jugador}', 'Admin\JugadorController@mostrarEditar');
Route::get('jugador/listar', 'Admin\JugadorController@consultarJugadores');

Route::post('jugador/registrar', 'Admin\JugadorController@store');
Route::post('jugador/actualizar', 'Admin\JugadorController@update')->name('jugador.actualizar');
Route::post('jugador/eliminar/{id_jugador}', 'Admin\JugadorController@eliminarJugador');

Route::post('crear_juego', 'JuegoController@crearJuego');
Route::get('terminar_juego', 'JuegoController@terminarJuego');

