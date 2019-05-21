<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_categories')) {
            Schema::create('project_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 100);
                $table->integer('sort_order')->nullable();
                $table->boolean('is_enabled')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('categories_project') && Schema::hasTable('pages')) {
            Schema::create('categories_project', function (Blueprint $table) {
                $table->integer('page_id')->unsigned();
                $table->integer('project_category_id')->unsigned();


                $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
                $table->foreign('project_category_id')->references('id')->on('project_categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_categories');
    }
}
