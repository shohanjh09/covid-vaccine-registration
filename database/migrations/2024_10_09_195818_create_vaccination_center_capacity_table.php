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
        Schema::create('vaccination_center_capacity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaccination_center_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('remaining_capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_center_capacity');
    }
};
