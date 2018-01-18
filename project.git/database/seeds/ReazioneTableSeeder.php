<?php

use Illuminate\Database\Seeder;

class ReazioneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('reazione')->insert(array(
			array(
			    'reazioneID'=> 1,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 2,
			    'postID' => 1,
			    'flag'=> 1,
			),
			array(
			    'reazioneID'=> 2,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 3,
			    'postID' => 1,
			    'flag'=> 1,
			),
			array(
			    'reazioneID'=> 3,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'postID' => 4,
			    'flag'=> 1,
			),
	));
    }
}
