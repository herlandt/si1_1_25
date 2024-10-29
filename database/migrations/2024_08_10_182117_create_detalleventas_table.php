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
        Schema::create('detalleventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id') // Clave foránea para la tabla ventas
                ->constrained() // Usa la tabla `ventas` por defecto
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Opcional: Elimina detalles si la venta es eliminada
            $table->float('monto');
            $table->integer('cantidad');
            $table->float('descuento');
            $table->float('preciocompra');
            $table->foreignId('producto_id') // Clave foránea para la tabla productos
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleventas');
    }
};
