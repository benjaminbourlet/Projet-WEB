<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::create('offers_departments', function (Blueprint $table) {
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->primary(['department_id', 'offer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers_departments');
    }
};

