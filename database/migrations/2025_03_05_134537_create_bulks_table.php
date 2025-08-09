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
        Schema::create('bulks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('units_per_bulk'); //cantidad de unidades por bulto
            $table->integer('quantity_bulk'); //cantidad de bultos en stock
            $table->decimal('price_per_bulk', 10, 2); // precio del bulto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulks');
    }
};
