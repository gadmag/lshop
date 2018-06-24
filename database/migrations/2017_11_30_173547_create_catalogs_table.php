<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('name');
            $table->text('description');
            $table->string('alias');
            $table->integer('order')->default(0);
            $table->integer('depth')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('user_id')->unsigned();
            $table->string('type');
            $table->timestamps();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cataloggables', function (Blueprint $table)
        {
            $table->integer('catalog_id')->unsigned()->index();
            $table->integer('cataloggable_id')->unsigned()->index();
            $table->string('cataloggable_type')->index();

            //$table->foreign('node_id')->references('id')->on('products')->onDelete('cascade');
            //$table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
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
        Schema::dropIfExists('cataloggables');
        Schema::dropIfExists('catalogs');


    }
}
