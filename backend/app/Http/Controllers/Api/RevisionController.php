<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Revision;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RevisionController extends Controller {

    public function getRevision(string $user_id): JsonResponse {
        $revision = Revision::where('user_id', $user_id)->first();

        return response()->json($revision);
    }

    public function getCards(string $user_id): JsonResponse {
        $revision = Revision::where('user_id', $user_id)->first();

        //Get cards in random order from active decks of the current user
        $cards = Card::where('level', '<', 8)
                    ->whereRelation('deck', 'active', 1)
                    ->whereRelation('deck', 'user_id', $user_id)
                    ->inRandomOrder()
                    ->get();

        $max_card_by_level = 10;

        $cards_by_level = [];
        $selected_cards = [];


        //Get the levels to review for this day using the start date of the revision
        $levels_to_get = [];

        $start_date = new DateTime($revision->start);
        $today = new DateTime();

        $days_past = $today->diff($start_date)->format("%a");

        //For each level, check if it should be reviewed
        for ($i = 1; $i < 8; $i++) {
            $day_to_review = 2**($i-1);
            if ($days_past%$day_to_review == 0) {
                $levels_to_get[] = $i;
            }
        }

        Log::debug("days past : $days_past");
        Log::debug("Levels to get : " . implode(" - ", $levels_to_get));

        //Go through retrieved cards and select only a certain amount for each level that has to be reviewed
        foreach ($cards as $card) {
            $level = $card->level;
            if (!in_array($level, $levels_to_get)) {
                continue;
            }
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