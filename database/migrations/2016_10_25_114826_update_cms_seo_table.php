<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCmsSeoTable extends Migration
{
    /**
     * Run the migrations.
     * Removing maxlength for the descriptions.
     * @return void
     */
    public function up()
    {
        Schema::table('seo', function ($table) {
            $table->string('description')->nullable()->change();
            $table->string('og_description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seo', function ($table) {
            $table->string('description', 160)->nullable()->change();
            $table->string('og_description', 160)->nullable()->change();
        });
    }
}
