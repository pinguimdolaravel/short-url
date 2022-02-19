<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();

            $table->string('url');
            $table->string('short_url');
            $table->string('code');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('short_urls');
    }
};
