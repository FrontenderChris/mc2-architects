<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('category', 100)->nullable();
            $table->timestamps();

            $table->unique(['slug', 'category']);
        });

        #####----------------------------------------------------------#####
        #                         UPLOADS (WYSIWYG)
        #####----------------------------------------------------------#####
        Schema::create('uploads', function(Blueprint $table){
            $table->increments('id');
            $table->string('title', 100);
            $table->string('filename')->unique();
            $table->text('caption')->nullable();
            $table->integer('size')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('mime_type');
            $table->timestamps();
        });

        #####----------------------------------------------------------#####
        #                            CONTACT FORM
        #####----------------------------------------------------------#####
        Schema::create('contact_entries', function(Blueprint $table){
            $table->increments('id');
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('company', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->text('data')->nullable();
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->timestamps();
        });

        #####----------------------------------------------------------#####
        #                      SUBSCRIBERS (NEWSLETTER)
        #####----------------------------------------------------------#####
        Schema::create('subscribers', function(Blueprint $table){
            $table->increments('id');
            $table->integer('subscribeable_id')->unsigned()->nullable();
            $table->string('subscribeable_type')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 100);
            $table->string('phone', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 100)->unique();
            $table->string('label', 100)->nullable();
            $table->text('value')->nullable();
            $table->string('validation')->nullable();
            $table->string('widget', 50)->default('_text');
            $table->string('group', 50)->default('general');
            $table->text('data')->nullable();
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });

        Schema::create('seo', function(Blueprint $table){
            $table->increments('id');
            $table->integer('seoable_id')->unsigned();
            $table->string('seoable_type');
            $table->string('title', 100)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->string('description', 160)->nullable();
            $table->string('og_title', 160)->nullable();
            $table->string('og_description', 160)->nullable();
            $table->timestamps();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('imageable_id')->unsigned()->nullable();
            $table->string('imageable_type')->nullable();
            $table->string('title', 100);
            $table->string('file');
            $table->string('type')->nullable()->default('default');
            $table->text('caption')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_main_image')->default(0);
            $table->integer('size')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->text('data')->nullable();
            $table->string('mime_type');
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });

        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('redirect_from');
            $table->string('redirect_to');
            $table->integer('code')->default(301);
            $table->boolean('is_enabled')->default(true);
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
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('contact_entries');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('seo');
        Schema::dropIfExists('redirects');
        Schema::dropIfExists('images');
    }
}
