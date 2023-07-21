<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id');
            $table->unsignedBigInteger('deleted_by_id');
            $table->string('uuid');
            $table->string('slug');
            $table->string('title');
            $table->string('image');
            $table->longText('content');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->foreign('deleted_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beritas');
    }
}
