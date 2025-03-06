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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_sale_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('payment_date');
            $table->decimal('amount_paid', 10, 2);
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('currency_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
