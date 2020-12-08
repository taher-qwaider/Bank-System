<?php

use App\Models\City;
use App\Models\Profession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('email', 45)->unique();
            $table->string('mobile', 45)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender', ['M', 'F']);
            $table->foreignIdFor(City::class);
            $table->foreign('city_id')->on('cities')->references('id')->restrictOnDelete();
            $table->foreignIdFor(Profession::class);
            $table->foreign('profession_id')->on('professions')->references('id')->restrictOnDelete();
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
        Schema::dropIfExists('_admins');
    }
}
