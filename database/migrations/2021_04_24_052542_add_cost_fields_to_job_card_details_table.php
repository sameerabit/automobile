<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostFieldsToJobCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_card_details', function (Blueprint $table) {
            $table->double('est_cost')->nullable();
            $table->double('actual_cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_card_details', function (Blueprint $table) {
            $table->dropColumn('est_cost');
            $table->dropColumn('actual_cost');
        });
    }
}
