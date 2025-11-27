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
        Schema::create('detalles_pedido', function (Blueprint $table) {
            $table->id();  // ID único para el detalle del pedido
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');  // Relación con el pedido
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');  // Relación con el producto
            $table->integer('cantidad');  // Cantidad de ese producto en el pedido
            $table->decimal('precio_total', 10, 2);  // Precio total del producto en el pedido
            $table->timestamps();  // Timestamps (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_pedido');
    }
};
