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
        Schema::create('carrito_compras', function (Blueprint $table) {
            $table->id();  // ID único para el carrito
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Relación con el usuario
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');  // Relación con el producto
            $table->integer('cantidad');  // Cantidad del producto en el carrito
            $table->decimal('precio_total', 10, 2);  // Precio total de ese producto en el carrito
            $table->timestamps();  // Timestamps (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_compras');
    }
};

