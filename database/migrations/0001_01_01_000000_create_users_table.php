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
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // ID único para el usuario
            $table->string('nombre');  // Nombre del usuario
            $table->string('apellido');  // Apellido del usuario
            $table->string('correo_electronico')->unique();  // Correo electrónico único
            $table->string('telefono', 20)->nullable();  // Teléfono del usuario
            $table->text('direccion_envio')->nullable();  // Dirección de envío del usuario
            $table->timestamp('email_verified_at')->nullable();  // Fecha de verificación del correo
            $table->string('password');  // Contraseña encriptada
            $table->rememberToken();  // Token para recordar la sesión
            $table->enum('role', ['admin', 'cliente'])->default('cliente');  // Rol del usuario (admin o cliente)
            $table->timestamps();  // Timestamps (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
