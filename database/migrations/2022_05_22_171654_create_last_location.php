<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_location', function (Blueprint $table) {
            $table->id();
            $table->integer('survivor_id');
            $table->float('lat',10,2);
            $table->float('lng',10,2);
            $table->timestamps();

            $table->foreign('survivor_id')->references('id')->on('survivors')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('last_location');
    }
}
