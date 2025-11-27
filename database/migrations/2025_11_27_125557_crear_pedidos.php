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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();  // ID único para el pedido
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Relación con el usuario que realiza el pedido
            $table->decimal('total_a_pagar', 10, 2);  // Total a pagar por el pedido
            $table->enum('estado', ['en espera', 'enviado', 'entregado'])->default('en espera');  // Estado del pedido
            $table->text('direccion_envio');  // Dirección de envío del pedido
            $table->string('cedula_identidad', 20)->nullable();  // Cédula de identidad del cliente
            $table->string('numero_celular', 20)->nullable();  // Número de celular del cliente
            $table->timestamps();  // Timestamps (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
