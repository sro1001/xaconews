<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('password/sendReset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@resetPassword')->name('password.reset');
Route::post('password/update', 'Auth\ResetPasswordController@updatePassword');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'noticias', 'as' => 'noticias.'], function () {
        Route::get('sincronizar_noticias', 'Noticias\NoticiasController@sincronizarNoticias')->name('sincronizar_noticias');
        Route::get('index', 'Noticias\NoticiasController@index')->name('index');
        Route::get('ver/{id}', 'Noticias\NoticiasController@ver')->name('ver');
        Route::put('revision/{id}', 'Noticias\NoticiasController@revision')->name('revision');
        Route::get('editar_texto_noticia/{id}', 'Noticias\NoticiasController@editarTextoNoticia')->name('editar_texto_noticia');
        Route::delete('eliminar', 'Noticias\NoticiasController@eliminar')->name('eliminar');
        Route::get('ver_noticia_dashboard/{id}', 'Noticias\NoticiasController@verNoticiaDashboard')->name('ver_noticia_dashboard');
        Route::get('exportar_noticias', 'Noticias\NoticiasController@exportarNoticias')->name('exportar_noticias');
    });

    Route::group(['prefix' => 'usuarios', 'as' => 'usuarios.'], function () {
        Route::get('index', 'Noticias\UsuariosNoticiasController@index')->name('index');
        Route::get('crear', 'Noticias\UsuariosNoticiasController@crear')->name('crear');
        Route::post('insertar', 'Noticias\UsuariosNoticiasController@insertar')->name('insertar');
        Route::get('editar/{id}', 'Noticias\UsuariosNoticiasController@editar')->name('editar');
        Route::put('actualizar/{id}', 'Noticias\UsuariosNoticiasController@actualizar')->name('actualizar');
        Route::put('cambiar_estado', 'Noticias\UsuariosNoticiasController@cambiar_estado')->name('cambiar_estado');
    });

    Route::group(['prefix' => 'sentimientos', 'as' => 'sentimientos.'], function () {
        Route::get('index', 'Noticias\AnalisisNoticiasController@index')->name('index');
        Route::get('analisis_sentimientos/{id}', 'Noticias\AnalisisNoticiasController@analisisSentimientos')->name('analisis_sentimientos');
    });
});

