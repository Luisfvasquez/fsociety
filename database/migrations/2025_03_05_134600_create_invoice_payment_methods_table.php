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
        Schema::create('invoice_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->decimal('total_amount', 15, 2);
            $table->foreignId('currency_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->dateTime('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payment_methods');
    }
};
