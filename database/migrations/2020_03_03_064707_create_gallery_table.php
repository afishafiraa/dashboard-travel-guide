<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourism_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tourism_id');
            $table->text('description')->nullable();
            $table->string('photo');
            $table->timestamps();
            $table->foreign('tourism_id')->references('id')->on('tourism')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourism_gallery');
    }
}
