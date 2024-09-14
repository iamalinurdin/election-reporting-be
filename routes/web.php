<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/reset-password/{token}', function (string $token) {
  $clientURL = env('CLIENT_URL');

  return redirect("{$clientURL}/reset-password?token={$token}");
})->middleware('guest')->name('password.reset');
