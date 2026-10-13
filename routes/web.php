<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $meals = [
        [
            'type' => 'breakfast',
            'name' => 'الفطار',
            'icon' => '🍳',
            'status' => 'closed',
        ],
        [
            'type' => 'lunch',
            'name' => 'الغداء',
            'icon' => '🍲',
            'status' => 'open',
        ],
        [
            'type' => 'dinner',
            'name' => 'العشاء',
            'icon' => '🍽️',
            'status' => 'closed',
        ],
    ];

    return view('home',compact('meals'));
});
