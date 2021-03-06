<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tarm-slug');
            $table->string('tarm-name');
            $table->longText('description')->nullable();
            $table->string('tarm-type')->nullable();
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
        Schema::dropIfExists('tarms');    
    }
}
