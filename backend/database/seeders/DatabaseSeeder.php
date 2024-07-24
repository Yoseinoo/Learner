<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Category;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()->count(5)->create();

        User::factory()->count(5)->create()->each(function ($user) {
            Deck::factory()->count(5)->create(['user_id' => $user->id])->each(function ($deck) {
                Card::factory()->count(5)->create(['deck_id' => $deck->id]);
            });
        });

        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'test@test.fr',
            'password' => bcrypt('test'),
        ]);
    }
}
