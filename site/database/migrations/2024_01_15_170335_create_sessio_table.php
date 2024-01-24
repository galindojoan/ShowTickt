<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessioTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sessios', function (Blueprint $table) {
            $table->id();
            $table->dateTime("data");
            $table->dateTime("tancament");
            $table->integer('aforament');
            $table->boolean('nominal')->default(false);
            $table->foreignId('esdeveniments_id')->constrained('esdeveniments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sessios');
    }
}
