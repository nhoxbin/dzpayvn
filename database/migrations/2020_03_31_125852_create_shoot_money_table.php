<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShootMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoot_money', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('sim_id');
            $table->foreign('sim_id')->references('id')->on('sims');
            $table->string('method', 4);
            $table->string('type')->nullable();
            $table->unsignedDecimal('money', 15, 2);
            $table->string('phone', 10);
            $table->string('password')->nullable();
            $table->tinyInteger('confirm')->default(0)->comment('-1: từ chối, 0: chưa xác nhận, 1: đã xác nhận');
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('shoot_money');
    }
}
