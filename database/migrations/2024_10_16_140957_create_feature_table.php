<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureTable extends Migration
{
    public function up()
    {
        Schema::create('Feature', function (Blueprint $table) {
            $table->id();
            $table->timestamp('TS_CREATED')->nullable();
            $table->timestamp('TS_LASTMODIFIED')->nullable();
            $table->boolean('ACTIVE')->nullable();
            $table->longText('JSON_VALUE')->nullable();
            $table->integer('CONTEXT_ID')->nullable();
            $table->text('CONTEXT_TABLE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Feature');
    }
}
