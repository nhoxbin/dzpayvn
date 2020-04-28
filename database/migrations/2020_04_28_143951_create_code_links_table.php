<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_links', function (Blueprint $table) {
            $table->string('phone_number', 11);
            $table->foreign('phone_number')->references('number')->on('phones')->onUpdate('cascade')->onDelete('cascade');
            $table->string('code', 6)->nullable();
            $table->unsignedBigInteger('link_id');
            $table->foreign('link_id')->references('id')->on('links')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['phone_number', 'link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_links');
    }
}
