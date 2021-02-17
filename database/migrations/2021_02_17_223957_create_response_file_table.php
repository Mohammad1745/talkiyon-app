<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_id');
            $table->string('file');
            $table->timestamps();

            $table->foreign('response_id')->references('id')->on('response')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('response_file');
    }
}
