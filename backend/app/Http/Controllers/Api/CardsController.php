<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardsController extends Controller {

    public function getCards(): JsonResponse {
        $cards = Card::all();
        return response()->json($cards);
    }

    public function getCardsForDeck(string $deck_id) {
        $cards = Card::where('deck_id', $deck_id)->get();
        return response()->json($cards);
    }

    /**
     * Save or create card in database
     */
    public function saveCard(Request $request): JsonResponse {
        $input = $request->input('card');

        $card = Card::updateOrCreate(
            ['id' => $input['id']],
            [
                'question' => $input['question'],
                'answer' => $input['answer'],
                'level' => $input['level'],
                'deck_id' => $input['deck_id']
            ]
        );

        return response()->json($card);
    }

    public function removeCard(string $id): JsonResponse {
        $cards_deleted = Card::where('id', $id)->delete();

        return response()->json($cards_deleted);
    }
}