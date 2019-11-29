<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_id');
            $table->dropColumn('payment_method');
            $table->dropColumn('shipment_method');
            $table->dropColumn('shipment_price');
            $table->dropColumn('coupon');

            $table->text('payment')->after('cart');
            $table->text('shipment')->after('cart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_id');
            $table->string('payment_method');
            $table->string('shipment_method');
            $table->string('shipment_price');
            $table->string('coupon');

            $table->dropColumn('payment');
            $table->dropColumn('shipment');
        });
    }
}
