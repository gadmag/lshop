<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpecialPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_options', function (Blueprint $table) {
            $table->dropColumn(['price_prefix','weight_prefix']);
//            $table->decimal('special_price',13,2)->after('price');
        });
//        Schema::table('products', function (Blueprint $table) {
//            $table->decimal('special_price',13,2)->after('price');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
