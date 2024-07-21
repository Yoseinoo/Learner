<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deck extends Model {
    use HasFactory;

    protected $fillable = ['id', 'label', 'description', 'active', 'public', 'user_id', 'category_id'];

    public function user(): BelongsTo { 
        return $this->belongsTo(User::class); 
    }

    public function cards() : HasMany {
        return $this->hasMany(Card::class); 
    }

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'public' => 'boolean'
        ];
    }
}
