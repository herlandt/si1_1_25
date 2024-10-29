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
        Schema::create('impresions', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->float('precio');
            $table->integer('cantidad');
            $table->float('total');
            $table->string('metodo');
            $table->string('estado');
            $table->foreignId('user_id') // Clave foránea para la tabla clientes
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
        Schema::dropIfExists('impresions');
    }
};
