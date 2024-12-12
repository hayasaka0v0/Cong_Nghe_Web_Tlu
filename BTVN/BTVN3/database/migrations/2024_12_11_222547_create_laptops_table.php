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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->text('specifications');
            $table->boolean('rental_status')->default(false); // false = Not rented
            $table->unsignedBigInteger('renter_id')->nullable(); // Can be null if not rented
            $table->foreign('renter_id')->references('id')->on('renters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
