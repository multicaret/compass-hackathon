<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('admin');
});
Route::get('admin/login', function () {
    Auth::loginUsingId(1);

    return redirect('admin');
})->name('filament.admin.auth.login');
