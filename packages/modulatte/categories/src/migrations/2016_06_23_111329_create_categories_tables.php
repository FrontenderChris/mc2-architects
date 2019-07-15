<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->increments('id');
                    $table->integer('parent_id')->unsigned()->nullable();
                $table->string('title', 100);
                $table->string('slug', 100)->unique();
                $table->text('data')->nullable();
                $table->integer('sort_order')->nullable();
                $table->boolean('is_enabled')->default(true);
                $table->timestamps();

                $table->index('parent_id');
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            });
        }

        if (!Schema::hasTable('categories_products') && Schema::hasTable('products')) {
            Schema::create('categories_products', function (Blueprint $table) {
                $table->integer('product_id')->unsigned();
                $table->integer('category_id')->unsigned();

                $table->primary(['product_id', 'category_id']);
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_parent_id_foreign');
        });

        if (Schema::hasTable('categories_products')) {
            Schema::table('categories_products', function (Blueprint $table) {
                $table->dropForeign('categories_products_product_id_foreign');
                $table->dropForeign('categories_products_category_id_foreign');
            });
            Schema::dropIfExists('categories_products');
        }

        Schema::dropIfExists('categories');

    }
}
