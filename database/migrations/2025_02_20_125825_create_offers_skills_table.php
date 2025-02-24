<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('offers_skills', function (Blueprint $table) {
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->primary(['offer_id', 'skill_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers_skills');
    }
};