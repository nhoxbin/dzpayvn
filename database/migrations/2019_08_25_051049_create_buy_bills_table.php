<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('package_id')->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
            $table->string('account_type');
            $table->string('info');
            $table->unsignedBigInteger('nv_id')->nullable();
            $table->string('name_character');
            $table->boolean('require_cancel')->default(0);
            $table->string('picture_to_confirm')->nullable();
            $table->tinyInteger('confirm')->default(0)->comment('-1: bị loại bỏ, 0: chưa xác nhận, 1: đã xác nhận');
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
        Schema::dropIfExists('buy_bills');
    }
}
