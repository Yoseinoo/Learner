<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/api/login', [AuthenticationController::class, 'login']);
Route::get('/api/deck/{id}', [ApiController::class, 'getDeck']);
Route::delete('/api/deck/{id}', [ApiController::class, 'removeDeck']);
Route::post('/api/deck', [ApiController::class, 'saveDeck']);
Route::get('/api/decks', [ApiController::class, 'getDecks']);//->middleware('auth:sanctum');
Route::get('/api/cards', [ApiController::class, 'getCards']);
Route::get('/api/cards/{deck_id}', [ApiController::class, 'getCardsForDeck']);