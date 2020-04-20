<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->string('recharge_bill_id')->primary();
            $table->foreign('recharge_bill_id')->references('id')->on('recharge_bills')->onDelete('cascade');
            $table->unsignedInteger('sim_id')->nullable();
            $table->foreign('sim_id')->references('id')->on('sims')->onDelete('set null');
            $table->string('serial');
            $table->string('code');
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
        Schema::dropIfExists('cards');
    }
}
