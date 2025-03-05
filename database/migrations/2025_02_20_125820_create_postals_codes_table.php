<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('postals_codes', function (Blueprint $table) {
            $table->id();
            $table->string('num', 5)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('postals_codes');
    }
};
