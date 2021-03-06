<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('first_name',64);
            $table->string('last_name',64);
            $table->string('telephone',32);
            $table->string('email');
            $table->string('company');
            $table->string('address',128);
            $table->string('postcode',128);
            $table->string('city');
            $table->string('country');
            $table->string('region');
            $table->text('comment');
            $table->text('comment_admin');
            $table->string('coupon');
            $table->boolean('is_send')->default(0);
            $table->integer('order_status_id');
            $table->string('payment_method',128);
            $table->string('payment_id',128);
            $table->string('shipment_method',128);
            $table->decimal('shipment_price',13, 2)->default(0.00);
            $table->decimal('totalPrice',13,2)->default(0.00);
            $table->text('cart');
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
        Schema::dropIfExists('orders');
    }
}
