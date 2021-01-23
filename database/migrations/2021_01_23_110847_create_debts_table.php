<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->float('total');
            $table->float('remain');
            $table->string('image');
            $table->enum('debt_type', ['Creditor', 'Debtor']);
            $table->enum('payment_type', ['Single', 'Multi']);
            $table->string('description');
            $table->date('date');

            $table->foreignId('debt_user_id');
            $table->foreign('debt_user_id')->on('debt_users')->references('id');

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
        Schema::dropIfExists('debits');
    }
}
