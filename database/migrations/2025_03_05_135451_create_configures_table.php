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
        Schema::create('configures', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('commercial_name'); // Nombre Comercial
            $table->string('fiscal_name'); // Nombre Fiscal
            $table->string('company_slogan'); // Eslogan de la Empresa
            $table->string('owner_name'); // Nombre del Propietario
            $table->string('fiscal_id_type'); // Identificación Fiscal
            $table->string('tax_name'); // Nombre del Impuesto
            $table->string('second_tax'); // 2° Impuesto
            $table->boolean('include_tax_prices'); // Precios con Impuesto incluido
            $table->string('company_address'); // Dirección de la Empresa
            $table->string('city'); // Población
            $table->string('postal_code'); // C. Postal
            $table->string('phone_number'); // Número de Teléfono
            $table->string('fax_number')->nullable(); // FAX/Tfno.2 (nullable)
            $table->string('mobile_phone'); // Teléfono Móvil
            $table->string('bank_account_number'); // N° de Cuenta Bancaria
            $table->boolean('use_bank_account_for_all_clients'); // Utilizar esta cuenta bancaria para todos los clientes
            $table->string('email'); // Correo Electrónico
            $table->string('website')->nullable(); // Página WEB (nullable)
            $table->string('invoice_number_format'); // Formato de Numeración para facturas
            $table->string('free_field_name'); // Nombre Campo Libre para Documentos
            $table->boolean('detect_duplicates_in_free_field'); // Detectar duplicados en Campo Libre
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configures');
    }
};
