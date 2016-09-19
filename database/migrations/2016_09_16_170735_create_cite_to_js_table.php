<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiteToJsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cite_to_js', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('js_article_id')->unsigned();
            $table->foreign('js_article_id')->references('id')->on('js');
            $table->string('titleOnGoogle');
            $table->string('cluster_id');
            $table->integer('cites');
            $table->text('mla');
            $table->text('apa');
            $table->text('chicago');
            $table->text('harvard');
            $table->text('vancouver');
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
        Schema::drop('cite_to_js');
    }
}
