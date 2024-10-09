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
        Schema::create('vaccine_center_capacity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaccine_center_id')->constrained()->onDelete('cascade');
            $table->date('date');  // The date for which capacity is being tracked
            $table->integer('remaining_capacity'); // Remaining slots for that day
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_center_capacity');
    }
};
