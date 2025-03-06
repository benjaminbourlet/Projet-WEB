<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::create('companies_sectors', function (Blueprint $table) {
            $table->foreignId('sector_id')->constrained('sectors')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->primary(['sector_id', 'company_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies_sectors');
    }
};

