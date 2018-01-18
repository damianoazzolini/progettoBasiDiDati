<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('post')->insert(array(
			array(
			    'postID'=> 1,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'contenuto' => 'Primo post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 2,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'contenuto' => 'Secondo post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 3,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 2,
			    'contenuto' => 'Terzo post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 4,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 3,
			    'contenuto' => 'Quarto post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 5,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 4,
			    'contenuto' => 'Quinto post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 6,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 5,
			    'contenuto' => 'Sesto post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 7,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 6,
			    'contenuto' => 'Settimo post',
			    'attivo' => 1,
			),
			array(
			    'postID'=> 8,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'contenuto' => 'Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
			    'attivo' => 1,
			),
	));
    }
}
