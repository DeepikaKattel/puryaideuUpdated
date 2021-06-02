<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\HasApiTokens;

class CreateUsersTable extends Migration
{
    use Notifiable, HasApiTokens;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('role')->default(3);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable();
            $table->date('dob')->nullable();
            $table->string('contact1');
            $table->string('contact2')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('password');
            $table->timestamp('approved_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
