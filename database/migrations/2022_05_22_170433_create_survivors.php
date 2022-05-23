<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurvivors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survivors', function (Blueprint $table) {
            $table->id();
            $table->string('survivor_id')->unique();
            $table->string('name');
            $table->integer('age');
            $table->tinyInteger('is_infected')->default(0)->comment('0:no 1:yes');
            $table->tinyInteger('gender')->comment('1:male 2:female');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survivors');
    }
}
