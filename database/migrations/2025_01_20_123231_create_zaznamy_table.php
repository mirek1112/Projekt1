<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZaznamyTable extends Migration
{
    public function up()
    {
        Schema::create('zaznamy', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('jmeno', 32);
            $table->string('prijmeni', 32);
            $table->date('datum')->nullable();
            $table->foreignId('country_id')->constrained('countries');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zaznamy');
    }
}
