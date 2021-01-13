<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTypeOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE orders MODIFY cart  LONGTEXT;');
//        Schema::create('orders', function (Blueprint $table) {
//            $table->longText('cart')->comment(' ')->change();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE orders MODIFY cart  TEXT;');
//        Schema::create('orders', function (Blueprint $table) {
//            $table->text('cart')->comment(' ')->change();
//        });
    }
}
