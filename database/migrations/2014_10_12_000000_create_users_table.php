<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('image')->nullable();
            $table->enum('gender', ['M', 'F']);
            $table->string('id_number', 15);
            $table->boolean('has_control');
            $table->date('birth_data')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'inctive', 'Freezed']);
            $table->string('password')->nullable();

            $table->foreignId('city_id');
            $table->foreign('city_id')->references('id')->on('cities');

            $table->foreignId('profession_id');
            $table->foreign('profession_id')->references('id')->on('professions');

            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
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
