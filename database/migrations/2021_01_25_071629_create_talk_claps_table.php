<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalkClapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_claps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talk_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('talk_id')->references('id')->on('talks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talk_claps');
    }
}
