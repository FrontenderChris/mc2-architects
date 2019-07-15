<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pages');
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('title', '100');
            $table->string('slug', '100')->unique();
            $table->string('form', '50')->nullable();
            $table->longText('data')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('is_dynamic')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('pages')->insert(
            [
                ['title' => 'Homepage', 'slug' => 'home', 'form' => '_home', 'created_at' => date('Y-m-d H:i:s')],
                ['title' => 'Contact Us', 'slug' => 'contact', 'form' => '_contact', 'created_at' => date('Y-m-d H:i:s')],
            ]
        );

        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->string('title', 100)->nullable();
            $table->string('form', 50)->nullable();
            $table->longText('data')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();

            $table->index('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
