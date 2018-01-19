<?php

use Illuminate\Database\Seeder;

class AmiciziaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('amicizia')->insert(array(
			array(
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID1' => 1,
			    'utenteID2' => 2,
			    'stato'=> 'accettata',
			),
			array(
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID1' => 3,
			    'utenteID2' => 1,
			    'stato'=> 'sospesa',
			),
			array(
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID1' => 1,
			    'utenteID2' => 4,
			    'stato'=> 'sospesa',
			),
			array(
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID1' => 5,
			    'utenteID2' => 1,
			    'stato'=> 'sospesa',
			),
			array(
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID1' => 6,
			    'utenteID2' => 1,
			    'stato'=> 'sospesa',
			),
	));
    }
}
