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
        Schema::table('pedidos', function (Blueprint $table) {
            if (! Schema::hasColumn('pedidos', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0);
            }

            if (! Schema::hasColumn('pedidos', 'impuestos')) {
                $table->decimal('impuestos', 10, 2)->default(0);
            }

            if (! Schema::hasColumn('pedidos', 'descuento')) {
                $table->decimal('descuento', 10, 2)->default(0);
            }

            if (! Schema::hasColumn('pedidos', 'metodo_pago')) {
                $table->string('metodo_pago')->nullable();
            }

            if (! Schema::hasColumn('pedidos', 'payment_status')) {
                $table->string('payment_status')->nullable();
            }

            if (! Schema::hasColumn('pedidos', 'payment_reference')) {
                $table->string('payment_reference')->nullable();
            }

            if (! Schema::hasColumn('pedidos', 'tracking_number')) {
                $table->string('tracking_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos', 'subtotal')) {
                $table->dropColumn('subtotal');
            }

            if (Schema::hasColumn('pedidos', 'impuestos')) {
                $table->dropColumn('impuestos');
            }

            if (Schema::hasColumn('pedidos', 'descuento')) {
                $table->dropColumn('descuento');
            }

            if (Schema::hasColumn('pedidos', 'metodo_pago')) {
                $table->dropColumn('metodo_pago');
            }

            if (Schema::hasColumn('pedidos', 'payment_status')) {
                $table->dropColumn('payment_status');
            }

            if (Schema::hasColumn('pedidos', 'payment_reference')) {
                $table->dropColumn('payment_reference');
            }

            if (Schema::hasColumn('pedidos', 'tracking_number')) {
                $table->dropColumn('tracking_number');
            }
        });
    }
};
