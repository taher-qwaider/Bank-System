<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_users', function (Blueprint $table) {
            $table->id();
            $table->boolean('manege_sub')->default(true);
            $table->foreignId('main_user_id');
            $table->foreign('main_user_id')->on('users')->references('id');

            $table->foreignId('sub_user_id');
            $table->foreign('sub_user_id')->on('users')->references('id');

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
        Schema::dropIfExists('sub_users');
    }
}
