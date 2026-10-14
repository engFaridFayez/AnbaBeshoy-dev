<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


// Food => صنف
class Food extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function mealSessions(): BelongsToMany
    {
        return $this->belongsToMany(MealSession::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
