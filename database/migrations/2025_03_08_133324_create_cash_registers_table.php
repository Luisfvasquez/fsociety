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
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('user_id')->constrained('users'); // Usuario que abre la caja
            $table->double('opening_balance'); // Monto inicial en caja
            $table->double('closing_balance')->nullable(); // Monto final en caja
            $table->double('total_cash_sales')->default(0); // Total de ventas en efectivo
            $table->double('total_card_sales')->default(0); // Total de ventas con tarjeta
            $table->double('total_credit')->default(0); // Total de ventas a crédito
            $table->double('total_payments')->default(0); // Total de pagos recibidos (efectivo/tarjeta)
            $table->double('total_expenses')->default(0); // Gastos registrados durante el turno
            $table->integer('total_transactions')->default(0); // Total de transacciones realizadas
            $table->integer('total_batches')->default(0); // Número de lotes (agrupa pagos en efectivo y tarjeta)
            $table->enum('status', ['abierta', 'cerrada','pendiente'])->default('pendiente'); // Estado de la caja
            $table->dateTime('open_date'); // Fecha de apertura
            $table->dateTime('close_date')->nullable(); // Fecha de cierre          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
