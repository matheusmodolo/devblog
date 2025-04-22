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
        Schema::create('artigos_desenvolvedores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artigo_id');
            $table->unsignedBigInteger('desenvolvedor_id');
            $table->timestamps();

            $table->foreign('artigo_id')->references('id')->on('artigos');
            $table->foreign('desenvolvedor_id')->references('id')->on('desenvolvedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artigos_desenvolvedores');
    }
};
