<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;


Route::get('/testRoute', function () {
    return response()->json(['message' => 'Hello World WEB']);
});