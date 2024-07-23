<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Revision;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RevisionController extends Controller {

    public function getRevision(string $user_id): JsonResponse {
        $revision = Revision::where('user_id', $user_id)->first();

        return response()->json($revision);
    }

    public function getCards(string $user_id): JsonResponse {
        $revision = Revision::where('user_id', $user_id);

        //Get cards in random order from active decks of the current user
        $cards = Card::where('level', '<', 8)
                    ->whereRelation('deck', 'active', 1)
                    ->whereRelation('deck', 'user_id', $user_id)
                    ->inRandomOrder()
                    ->get();

        $max_card_by_level = 10;

        $cards_by_level = [];
        $selected_cards = [];

        //Go through retrieved cards and select only a certain amount for each level
        foreach ($cards as $card) {
            $level = $card->level;
            if (!isset($cards_by_level[$level])) {
                $cards_by_level[$level] = 1;
                $selected_cards[] = $card;
            } else if ($cards_by_level[$level] < $max_card_by_level) {
                $cards_by_level[$level] += 1;
                $selected_cards[] = $card;
            }
        }

        return response()->json($selected_cards);
    }
}