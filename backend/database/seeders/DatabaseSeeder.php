<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Deck::factory()
            ->count(20)
            ->create();
        
        Card::factory()
            ->count(50)
            ->hasDeck(1)
            ->create();
    }
}
