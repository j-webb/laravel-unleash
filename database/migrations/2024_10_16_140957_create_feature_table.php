<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureTable extends Migration
{
    public function up()
    {
        Schema::create('FEATURES', function (Blueprint $table) {
            $table->bigInteger('ID')->autoIncrement();
            $table->timestamp('TS_CREATED')->useCurrent(); 
            $table->timestamp('TS_LASTMODIFIED')->nullable()->useCurrentOnUpdate(); 
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
