<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller {

    public function getDeck(string $id): JsonResponse {
        $deck = Deck::find($id);
        return response()->json($deck);
    }

    public function getDecks(): JsonResponse {
        //Gate::authorize('viewAny', Todo::class);
        $user = Auth::user();
        $decks = Deck::all();
        return response()->json($decks); 
    }

    /**
     * Save or create deck in database
     */
    public function saveDeck(Request $request): JsonResponse {
        $input = $request->input('deck');
        $deck = Deck::updateOrCreate(
            ['id' => $input['id']],
            [
                'label' => $input['label'],
                'description' => $input['description'],
                'active' => $input['active'],
                'public' => $input['public'],
                'user_id' => 1,
                'category_id' => 1
            ]
        );
        return response()->json($deck);
    }

    public function removeDeck(string $id): JsonResponse {
        //Deleting cards associated to deck first
        $cards_deleted = Card::where('deck_id', $id)->delete();
        $deck_deleted = Deck::where('id', $id)->delete();

        $resp = [
            $cards_deleted,
            $deck_deleted
        ];
        return response()->json($resp);
    }

    public function getCards(): JsonResponse {
        $cards = Card::all();
        return response()->json($cards);
    }

    public function getCardsForDeck(string $deck_id) {
        $cards = Card::where('deck_id', $deck_id)->get();
        return response()->json($cards);
    }
}