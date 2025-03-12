<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app'); // Load Vue app
})->where('any', '^(?!api).*$'); // Matches any route
