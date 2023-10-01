<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// routes/api.php

use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'getUsers']);
Route::get('/users/{id}', [UserController::class, 'getUser']);


