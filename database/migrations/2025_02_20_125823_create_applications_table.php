<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->date('postulation_date');
            $table->string('cv', 255)->nullable();
            $table->text('cover_letter');
            $table->foreignId('offer_id')->constrained('offers');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};

