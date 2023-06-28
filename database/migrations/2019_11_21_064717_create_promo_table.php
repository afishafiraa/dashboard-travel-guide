<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->integer('value');
            $table->text('description')->nullable();
            $table->enum('category', ['discount', 'price-cut']);
            $table->integer('max-cut')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('merchant_items')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
