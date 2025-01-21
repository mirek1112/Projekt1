<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZaznamyHobbyTable extends Migration
{
    public function up()
    {
        Schema::create('zaznamy_hobby', function (Blueprint $table) {
            $table->id();
            $table->string('zaznamy_id');
            $table->unsignedBigInteger('hobby_id');
            $table->foreign('zaznamy_id')->references('id')->on('zaznamy')->onDelete('cascade');
            $table->foreign('hobby_id')->references('id')->on('hobbies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zaznamy_hobby');
    }
}
