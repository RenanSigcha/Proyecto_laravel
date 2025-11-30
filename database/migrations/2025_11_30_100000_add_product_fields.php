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
        Schema::table('productos', function (Blueprint $table) {
            if (! Schema::hasColumn('productos', 'sku')) {
                $table->string('sku')->nullable()->unique();
            }

            if (! Schema::hasColumn('productos', 'slug')) {
                $table->string('slug')->nullable()->unique();
            }

            if (! Schema::hasColumn('productos', 'marca')) {
                $table->string('marca')->nullable();
            }

            if (! Schema::hasColumn('productos', 'activo')) {
                $table->boolean('activo')->default(true);
            }

            if (! Schema::hasColumn('productos', 'peso')) {
                $table->decimal('peso', 8, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'sku')) {
                $table->dropUnique(['sku']);
                $table->dropColumn('sku');
            }

            if (Schema::hasColumn('productos', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('productos', 'marca')) {
                $table->dropColumn('marca');
            }

            if (Schema::hasColumn('productos', 'activo')) {
                $table->dropColumn('activo');
            }

            if (Schema::hasColumn('productos', 'peso')) {
                $table->dropColumn('peso');
            }
        });
    }
};
