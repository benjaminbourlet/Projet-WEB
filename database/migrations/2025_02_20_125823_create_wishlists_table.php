<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->foreignId('offer_id')->constrained('offers');
            $table->foreignId('user_id')->constrained('users');
            $table->primary(['user_id', 'offer_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
};
