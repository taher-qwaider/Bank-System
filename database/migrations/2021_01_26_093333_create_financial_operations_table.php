<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_operations', function (Blueprint $table) {
            $table->id();
            $table->string('source_type', 45);
            $table->bigInteger('source_id');
            $table->string('destination_type', 45);
            $table->bigInteger('destination_id');
            $table->float('amount');
            $table->boolean('verified');
            $table->string('verification_code', 45);
            $table->date('date');
            $table->time('time');

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
        Schema::dropIfExists('financial_operations');
    }
}
