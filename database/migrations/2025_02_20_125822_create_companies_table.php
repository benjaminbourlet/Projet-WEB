<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->string('email', 50);
            $table->string('logo_path', 255);
            $table->string( 'tel_number', 50)->unique()->nullable();
            $table->string( 'address', 255)->nullable();
            $table->string( 'siret', 14)->unique();
            $table->foreignId('city_id')->constrained('cities');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};