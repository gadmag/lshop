<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('product_discounts', function (Blueprint $table) {
//            $table->dropColumn(['price_prefix','date_start','date_end']);
//        });

        Schema::create('product_option_discounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('option_id')->index();
            $table->integer('quantity')->length(4);
            $table->decimal('price',13,2)->default(0.00);
        });

//        Schema::dropIfExists('product_discounts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_option_discounts');

    }
}
