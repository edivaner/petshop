<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;



// CRIAR AS ROTAS DO AUTHENTICATE




//Tutor
Route::get('/tutors', [TutorController::class, 'index']);
Route::get('/tutors/{id}', [TutorController::class, 'show']);
Route::post('/tutors', [TutorController::class, 'store']);
Route::put('/tutors/{id}', [TutorController::class, 'update']);
Route::delete('/tutors/{id}', [TutorController::class, 'destroy']);
?>