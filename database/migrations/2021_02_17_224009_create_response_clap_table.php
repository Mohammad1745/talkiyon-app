<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseClapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_clap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('response_id')->references('id')->on('response')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('response_clap');
    }
}
