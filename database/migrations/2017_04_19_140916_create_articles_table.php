<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateArticlesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',32);
            $table->string('alias');
            $table->string('title');
            $table->text('description');
            $table->text('body');
            $table->integer('user_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->timestamp('published_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }
}
