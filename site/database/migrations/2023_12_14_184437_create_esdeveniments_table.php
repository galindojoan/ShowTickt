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
        Schema::create('esdeveniments', function (Blueprint $table) {
            $table->id(); 
            $table->string('nom');
            $table->date('dia');
            $table->string('imatge');
            $table->decimal('preu', 8, 2);
            $table->foreignId('recinte_id')->constrained('recintes');
            $table->foreignId('categoria_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esdeveniments');
    }
};
