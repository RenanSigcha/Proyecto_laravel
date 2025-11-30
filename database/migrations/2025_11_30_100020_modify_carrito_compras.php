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
        Schema::table('carrito_compras', function (Blueprint $table) {
            if (! Schema::hasColumn('carrito_compras', 'session_id')) {
                $table->string('session_id')->nullable();
            }

            if (! Schema::hasColumn('carrito_compras', 'precio_unitario')) {
                $table->decimal('precio_unitario', 10, 2);
            }

            if (! Schema::hasColumn('carrito_compras', 'subtotal')) {
                $table->decimal('subtotal', 10, 2);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrito_compras', function (Blueprint $table) {
            if (Schema::hasColumn('carrito_compras', 'session_id')) {
                $table->dropColumn('session_id');
            }

            if (Schema::hasColumn('carrito_compras', 'precio_unitario')) {
                $table->dropColumn('precio_unitario');
            }

            if (Schema::hasColumn('carrito_compras', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};
