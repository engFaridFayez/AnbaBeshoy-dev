<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MealSession extends Model
{
    protected $fillable = [
        'date',
        'type',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date'
        ];
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
