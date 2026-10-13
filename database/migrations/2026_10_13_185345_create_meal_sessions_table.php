<?php

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
        Schema::create('meal_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->enum('type',[
                'breakfast',
                'lunch',
                'dinner'
            ]);
            $table->enum('status',[
                'open',
                'closed',
            ])->default('closed');
            $table->unique(['date','type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_sessions');
    }
};
