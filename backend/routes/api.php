<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CardsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\DecksController;
use App\Http\Controllers\Api\RevisionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/api/user', function (Request $request) { return $request->user(); })->middleware('auth:sanctum');
Route::post('/api/login', [AuthenticationController::class, 'login']);

Route::get('/api/deck/{id}', [DecksController::class, 'getDeck'])->middleware('auth:sanctum');
Route::delete('/api/deck/{id}', [DecksController::class, 'removeDeck'])->middleware('auth:sanctum');
Route::post('/api/deck', [DecksController::class, 'saveDeck'])->middleware('auth:sanctum');
Route::get('/api/decks', [DecksController::class, 'getDecks'])->middleware('auth:sanctum');
Route::get('/api/decks/{id}', [DecksController::class, 'getDecksForUser'])->middleware('auth:sanctum');
Route::post('/api/deck/duplicate', [DecksController::class, 'duplicateDeck'])->middleware('auth:sanctum');

Route::get('/api/cards', [CardsController::class, 'getCards'])->middleware('auth:sanctum');
Route::get('/api/cards/{deck_id}', [CardsController::class, 'getCardsForDeck'])->middleware('auth:sanctum');
Route::post('/api/card', [CardsController::class, 'saveCard'])->middleware('auth:sanctum');
Route::delete('/api/card/{id}', [CardsController::class, 'removeCard'])->middleware('auth:sanctum');

Route::get('/api/revision/{user_id}', [RevisionController::class, 'getRevision'])->middleware('auth:sanctum');
Route::get('/api/revision/cards/{user_id}', [RevisionController::class, 'getCards'])->middleware('auth:sanctum');

Route::get('/api/categories', [CategoriesController::class, 'getAll'])->middleware('auth:sanctum');