<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMomosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('momos', function (Blueprint $table) {
            $table->string('recharge_bill_id')->primary();
            $table->foreign('recharge_bill_id')->references('id')->on('recharge_bills')->onDelete('cascade');
            $table->string('phone', 11);
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
        Schema::dropIfExists('momos');
    }
}
