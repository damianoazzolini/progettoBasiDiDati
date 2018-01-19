<?php

use Illuminate\Database\Seeder;

class CommentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('commento')->insert(array(
			array(
			    'commentoID'=> 1,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 3,
			    'postID' => 1,
			    'contenuto'=> 'Commento 1',
			    'attivo' => 1,
			),
			array(
			    'commentoID'=> 2,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 2,
			    'postID' => 8,
			    'contenuto'=> 'Commento 2',
			    'attivo' => 1,
			)
	));
    }
}
