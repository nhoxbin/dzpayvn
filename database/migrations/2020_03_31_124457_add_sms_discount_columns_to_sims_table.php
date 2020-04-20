<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsDiscountColumnsToSimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sims', function (Blueprint $table) {
            $table->string('fast_discount')->default(0)->after('discount');
            $table->string('slow_discount')->default(0)->after('fast_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sims', function (Blueprint $table) {
            $table->dropColumn(['fast_discount', 'slow_discount']);
        });
    }
}
