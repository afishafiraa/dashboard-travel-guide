<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxQrcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_qrcode', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('qrcode_id');
            $table->timestamp('trx_time');
            $table->timestamps();
            $table->foreign('qrcode_id')->references('id')->on('qrcode')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_qrcode');
    }
}
