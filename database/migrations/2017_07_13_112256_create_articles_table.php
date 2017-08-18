<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table){
            $table->increments('id');
            $table->boolean('published')->default(false);
            $table->boolean('featured')->default(false);
            $table->timestamp('publication')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('article_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('locale');
            $table->string('title');
            $table->text('content');
            $table->text('short');
            $table->string('slug')->unique();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->integer('article_id')->unsigned();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_translations');
        Schema::dropIfExists('articles');
    }
}
