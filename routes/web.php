<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empresa', function () {
    return view('site/empresa');
});

Route::any ('/any', function(){
    return 'Permite todos os métodos HTTP (put, post, get, delete)';
});

Route::match(['gets', 'post'], '/match', function(){
    return 'Permite apenas acessos definifdos';
});

Route::get('/produto/{id}/{cat?}', function($id, $cat = ''){
    return 'Produto id: '.$id.' da categoria: '.$cat;
});