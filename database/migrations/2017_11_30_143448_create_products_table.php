<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('description')->default('');
            $table->string('alias');
            $table->string('model', 64)->default('');
            $table->string('sku', 64);
            $table->integer('quantity')->default(0);
            $table->integer('total_selling')->default(0);
            $table->integer('sort_order')->default(0);
            $table->string('size',128)->default('');
            $table->string('material')->default('');
            $table->string('type',24)->default('product');
            $table->decimal('price',13,2)->default(0.00);
            $table->boolean('status')->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
