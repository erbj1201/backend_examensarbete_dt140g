<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('animalId', 12);
            $table->string('earNo', 4);
            $table->string('breed', 20);
            $table->string('name', 56);
            $table->string('birthDate', 10);
            $table->string('sex', 4);
            $table->string('category', 20)->nullable();
            $table->bigInteger('herd_id')->unsigned();
            $table->string('imagepath')->nullable();
            $table->timestamps();
            $table->foreign('herd_id')->references('id')->on('herds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
