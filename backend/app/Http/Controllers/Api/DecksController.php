<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DecksController extends Controller {

    public function getDeck(string $id): JsonResponse {
        $deck = Deck::find($id);
        return response()->json($deck);
    }

    public function getDecks(): JsonResponse {
        $decks = Deck::where('public', 1)->get();
        return response()->json($decks); 
    }

    public function getDecksForUser(string $id): JsonResponse {
        $decks = Deck::where('user_id', $id)->get();
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

    public function duplicateDeck(Request $request): Response {
        $input = $request->validate([
            'deck_id' => ['required'],
            'user_id' => ['required']
        ]);

        //Duplicate the deck and update the user_id
        $deck = Deck::find($input['deck_id']);
        $dup = $deck->replicate();
        $dup->user_id = $input['user_id'];
        $dup->public = false;
        $dup->save();

        $cards = Card::where('deck_id', $input['deck_id'])->get();
        foreach ($cards as $card) {
            $new_card = $card->replicate();
            $new_card->deck_id = $dup->id;
            $new_card->save();
        }

        return response(201);
    }
}