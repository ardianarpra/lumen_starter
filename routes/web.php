<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\MahasiswaController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/mahasiswa', 'MahasiswaController@index');
$router->post('/mahasiswa', 'MahasiswaController@store');
$router->get('/mahasiswa/{id}', 'MahasiswaController@show');
$router->put('/mahasiswa/{id}', 'MahasiswaController@update');
$router->delete('/mahasiswa/{id}', 'MahasiswaController@destroy');

//Gawat Darurat
$router->get('/gawatdarurat', 'GawatDaruratController@index');
$router->post('/gawatdarurat', 'GawatDaruratController@storeGawatDarurat');
$router->patch('/gawatdarurat/penilaian/{id}', 'GawatDaruratController@storeGawatDaruratPenilaian');
$router->get('/gawatdarurat/{id}', 'GawatDaruratController@readGawatDaruratById');
$router->delete('/gawatdarurat/{id}', 'GawatDaruratController@deleteGawatDarurat');

//Berita
$router->get('/berita', 'BeritaController@index');
$router->post('/berita', 'BeritaController@storeBerita');
$router->patch('/berita/like/{beritaId}/{userId}', 'BeritaController@storeLikeBerita');
$router->get('/berita/{id}', 'BeritaController@readBeritaById');
$router->put('/berita/{id}', 'BeritaController@updateBerita');
$router->delete('/berita/{id}', 'BeritaController@deleteBerita');

$router->post('/register', 'StaffController@register');
$router->post('/login', 'StaffController@login');

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/me', 'StaffController@me');
});
