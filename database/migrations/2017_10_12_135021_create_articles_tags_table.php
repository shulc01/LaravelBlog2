<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tags', function (Blueprint $table) { //

            $table->increments('id');
            $table->integer('article_id')->unsigned();

            $table->foreign('article_id')
                ->references('id')->on('articles')
                ->onDelete('cascade');
            
            $table->integer('tag_id')->unsigned();

            $table->foreign('tag_id')
                ->references('id')->on('tags');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_tags');
    }
}
