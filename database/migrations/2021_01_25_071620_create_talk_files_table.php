<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talk_id');
            $table->tinyInteger('file_type');
            $table->string('file');
            $table->timestamps();

            $table->foreign('talk_id')->references('id')->on('talks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talk_files');
    }
}
