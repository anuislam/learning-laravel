<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class insertcomment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world comment',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 1,
        ]);
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world commentsss',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 0,
        ]);
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world dsdsds',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 0,
        ]);
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world aaa',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 0,
        ]);
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world aaa',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 0,
        ]);
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world aaa',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 0,
        ]);
		DB::table('comment')->insert([
            'comment_post_id' 	=> 15,
            'comment_author' 	=> 'anuislam shohag',
            'comment_email' 	=> 'anuislams@gmail.com',
            'comment_url' 		=> 'http://google.com',
            'comment_ip' 		=> '113.11.18.8',
	        'created_at' 		=> new \DateTime(),
	        'updated_at' 		=> new \DateTime(),
	        'comment_content' 	=> 'hello world aaa',
	        'user_id' 			=> 1,
	        'comment_approved' 	=> 0,
        ]);
    }
}
