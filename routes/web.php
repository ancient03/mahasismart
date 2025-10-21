<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page/home');
});

Route::get('/register', function () {
    return view('page/auth/register');
});

Route::get('/login', function () {
    return view('page/auth/login');
});

route::get('/search', function () {
    return view('page/search');
});

route::get('/profile', function () {
    return view('page/profile/profile');
});

route::get('/keranjang', function () {
    return view('page/product/chart');
});
  
route::get('/detailproduk', function () {
    return view('page/products/detailproduk');
});