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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            
            $table->unsignedBigInteger('film_id');
            
            
            $table->unsignedInteger('nombre_votes')->default(0);
            $table->unsignedInteger('total_notes')->default(0);
            $table->decimal('note_moyenne', 3, 2)->default(0.00);

            
            $table->foreign('film_id')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};