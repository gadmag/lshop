<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_link', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('link_title');
            $table->integer('parent_id')->default(0);
            $table->string('link_path');
            $table->integer('order')->default(0);
            $table->integer('menu_linktable_id')->nullable();
            $table->string('menu_linktable_type')->nullable();
            $table->boolean('status');
            $table->string('menu_type', 32);

//            $table->timestamps();
        });

//        Schema::table('users', function (Blueprint $table) {
//            $table->renameColumn('article_id', 'node_id');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_link');
    }
}
