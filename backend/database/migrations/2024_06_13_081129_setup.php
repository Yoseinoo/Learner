<?php

use App\Models\Category;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable(false);
            $table->string('description');
            $table->boolean('active')->default(false);
            $table->boolean('public')->default(false);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Category::class);
            $table->timestamps();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('question')->nullable(false);
            $table->string('answer')->nullable(false);
            $table->integer('level')->default(1);
            $table->foreignIdFor(Deck::class);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('categories');
    }
};
