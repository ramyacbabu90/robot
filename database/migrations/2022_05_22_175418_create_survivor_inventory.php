<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurvivorInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survivor_inventory', function (Blueprint $table) {
            $table->id();
            $table->integer('survivor_id');
            $table->integer('water');
            $table->text('food_items',150)->nullable();
            $table->text('medicine',150)->nullable();
            $table->text('ammunition',150)->nullable();
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
        Schema::dropIfExists('survivor_inventory');
    }
}
