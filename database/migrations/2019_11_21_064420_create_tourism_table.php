<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourismTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourism', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('gallery_id')->nullable();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('address', 100);
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('city')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourism');
    }
}
