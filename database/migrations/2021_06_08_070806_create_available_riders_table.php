<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_riders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rider_id');
            $table->foreign('rider_id')->references('id')->on('riders');
            $table->string('location');
            $table->string('status')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_riders');
    }
}
