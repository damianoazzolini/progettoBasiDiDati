<?php

use Illuminate\Database\Seeder;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('media')->insert(array(
        	array(
        	    'mediaID'=> 1,
        	    'created_at' => now(),
        	    'updated_at'=> now(),
        	    'postID' => 1,
        	    'percorso'=> '/systemImages/defaultUserImage.svg',
        	),
	));
    }
}
