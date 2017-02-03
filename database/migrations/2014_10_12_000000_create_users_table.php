<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('country_code', 2);
            $table->char('gender', 1);
            $table->string('email')->unique();
            $table->decimal('cash_value', 6, 2)->default(0);
            $table->decimal('bonus_value', 6, 2)->default(0);
            $table->integer('bonus_parameter')->default(0);
            $table->integer('no_deposits')->default(0);
            $table->integer('no_withdrawals')->default(0);
            $table->timestamp('created_at')->useCurrent();
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
