<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->string('cv', 255);
            $table->text('cover_letter')->nullable();
            $table->foreignId('offer_id')->constrained('offers');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('status_id')->constrained('statuses');
            $table->primary(['user_id', 'offer_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};

