<?php

use App\Http\Controllers\API\DespesaController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware('auth:sanctum')->get('/teste', function (Request $request) {
    return ['user' => $request->user(), 'message' => "Aeeee"];
});

Route::middleware('auth:sanctum')->controller(DespesaController::class)->prefix('despesas')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'create');
    Route::get('/{id}', 'show');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});
