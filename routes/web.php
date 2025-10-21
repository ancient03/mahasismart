<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page/homepage');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
});

route::get('/homepage', function () {
    return view('page/homepage');
});

route::get('/search', function () {
    return view('page/search');
});

route::get('/profile', function () {
    return view('page/profile');
});

route::get('/keranjang', function () {
    return view('page/chart');
});