<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cities_postals_codes', function (Blueprint $table) {
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('postal_code_id')->constrained('postals_codes')->onDelete('cascade');
            $table->primary(['city_id', 'postal_code_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities_postals_codes');
    }
};