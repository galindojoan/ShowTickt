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
        Schema::create('esdeveniment', function (Blueprint $table) {
            $table->id(); 
            $table->string('nom');
            $table->date('dia');
            $table->string('imatge');
            $table->integer('preu');
            $table->foreignId('recinteId')->constrained(
                table: 'recinte', indexName: 'id_recinte'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esdeveniment');
    }
};
