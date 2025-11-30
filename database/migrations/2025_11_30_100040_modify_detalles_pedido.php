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
        Schema::table('detalles_pedido', function (Blueprint $table) {
            if (! Schema::hasColumn('detalles_pedido', 'precio_unitario')) {
                $table->decimal('precio_unitario', 10, 2);
            }

            if (! Schema::hasColumn('detalles_pedido', 'subtotal')) {
                $table->decimal('subtotal', 10, 2);
            }

            if (! Schema::hasColumn('detalles_pedido', 'producto_nombre')) {
                $table->string('producto_nombre')->nullable();
            }

            if (! Schema::hasColumn('detalles_pedido', 'producto_sku')) {
                $table->string('producto_sku')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_pedido', function (Blueprint $table) {
            if (Schema::hasColumn('detalles_pedido', 'precio_unitario')) {
                $table->dropColumn('precio_unitario');
            }

            if (Schema::hasColumn('detalles_pedido', 'subtotal')) {
                $table->dropColumn('subtotal');
            }

            if (Schema::hasColumn('detalles_pedido', 'producto_nombre')) {
                $table->dropColumn('producto_nombre');
            }

            if (Schema::hasColumn('detalles_pedido', 'producto_sku')) {
                $table->dropColumn('producto_sku');
            }
        });
    }
};
