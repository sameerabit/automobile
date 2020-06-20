<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_bill_details', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_bill_id');
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->float('quantity');
            $table->float('buying_price');
            $table->float('selling_price');
            $table->softDeletes();
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
        Schema::dropIfExists('supplier_bill_details');
    }
}
