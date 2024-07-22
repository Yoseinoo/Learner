<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\JsonResponse;

class CardsController extends Controller {

    public function getCards(): JsonResponse {
        $cards = Card::all();
        return response()->json($cards);
    }

    public function getCardsForDeck(string $deck_id) {
        $cards = Card::where('deck_id', $deck_id)->get();
        return response()->json($cards);
    }
}