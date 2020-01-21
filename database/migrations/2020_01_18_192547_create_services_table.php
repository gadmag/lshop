<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('type');
            $table->decimal('price',13,2)->default(0.00);
            $table->integer('order')->default(0);
            $table->boolean('status')->default(0);
            $table->integer('product_id')->unsigned();
            $table->timestamps();
        });
        Schema::create('product_service', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
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
        Schema::dropIfExists('services');
        Schema::dropIfExists('product_service');
    }
}
