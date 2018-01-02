<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Menuitemstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->nullable()->default(NULL);
            $table->longText('url')->nullable()->default(NULL);
            $table->longText('attr')->nullable()->default(NULL);
            $table->bigInteger('parent_id')->nullable()->default(NULL);
            $table->bigInteger('menu_id')->nullable()->default(NULL);
            $table->bigInteger('menu_order')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('menu_items');
    }
}
