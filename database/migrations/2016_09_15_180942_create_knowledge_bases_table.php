<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKnowledgeBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_base_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('knowledge_bases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('knowledge_base_category_id')->nullable()->unsigned();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->text('content')->nullable();
            $table->interger('user_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('knowledge_base_category_id')
                ->references('id')
                ->on('knowledge_base_categories')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('knowledge_base_categories');
        Schema::drop('knowledge_bases');
    }
}
