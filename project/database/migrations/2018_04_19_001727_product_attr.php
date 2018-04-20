<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductAttr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attr', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->bigInteger('attr_id');
            $table->string('item_name', 255);
            $table->string('item_slug', 255);
            $table->longText('item_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attr');
    }
}
