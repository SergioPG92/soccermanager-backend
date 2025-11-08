<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('acciones');
});

Route::get('/saludo', function () {
    return 'holaaa';
});



