<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('title');
            $table->string('alt');
            $table->string('mime');
            $table->string('type');
            $table->integer('uploadstable_id');
            $table->string('uploadstable_type');
            $table->timestamps();
        });

        Schema::table('uploads',function (Blueprint $table){
//            $table->foreign('node_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('uploads');
    }
}
