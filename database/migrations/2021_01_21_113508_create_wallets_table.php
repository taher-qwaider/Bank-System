<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->float('total')->default(0);
            $table->boolean('active')->default(true);

            $table->foreignId('user_id');
            $table->foreign('user_id')->on('users')->references('id');

            $table->foreignId('currency_id');
            $table->foreign('currency_id')->on('currencies')->references('id');

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
        Schema::dropIfExists('wallets');
    }
}
