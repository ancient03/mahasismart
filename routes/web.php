<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('/register', function () {
    return view('register');
});
=======
Route::get('/login', function () {
    return view('login');
});
>>>>>>> 497659db255ed0d4fc332b221db3cebe8778d8fb
