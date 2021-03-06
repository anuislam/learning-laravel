<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Post extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_title');
            $table->string('post_slug')->nullable();
            $table->bigInteger('post_author');
            $table->longText('post_content')->nullable();
            $table->string('post_password')->nullable();
            $table->bigInteger('post_parent')->default(0);
            $table->bigInteger('comment_count')->default(0);
            $table->string('post_type')->default(0);
            $table->smallInteger('status')->default(0);
            $table->string('user_agent')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
