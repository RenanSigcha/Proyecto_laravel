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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();  // ID único para el producto
            $table->string('nombre');  // Nombre del producto
            $table->text('descripcion')->nullable();  // Descripción del producto
            $table->decimal('precio', 10, 2);  // Precio del producto
            $table->string('imagen_url')->nullable();  // URL de la imagen
            $table->integer('cantidad_disponible');  // Cantidad disponible
            $table->enum('categoria', ['semillas', 'fertilizantes', 'pesticidas']);  // Categoría del producto
            $table->timestamps();  // Timestamps (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
