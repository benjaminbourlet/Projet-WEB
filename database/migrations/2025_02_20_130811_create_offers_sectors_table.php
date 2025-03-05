<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::create('offers_sectors', function (Blueprint $table) {
            $table->foreignId('sector_id')->constrained('sectors')->onDelete('cascade');
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->primary(['sector_id', 'offer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_classes');
    }
};

