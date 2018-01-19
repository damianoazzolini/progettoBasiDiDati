<?php

use Illuminate\Database\Seeder;

class NotificaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('notifica')->insert(array(
			array(
			    'notificaID'=> 1,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'commento',
			    'tipoID' => 1,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 2,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'reazione',
			    'tipoID' => 1,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 3,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'reazione',
			    'tipoID' => 2,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 4,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 3,
			    'tipo' => 'reazione',
			    'tipoID' => 3,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 5,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 4,
			    'tipo' => 'amicizia',
			    'tipoID' => 1,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 6,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'amicizia',
			    'tipoID' => 5,
			    'letta' => 1,
			),
			array(
			    'notificaID'=> 7,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'amicizia',
			    'tipoID' => 2,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 8,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'amicizia',
			    'tipoID' => 6,
			    'letta' => 1,
			),
			array(
			    'notificaID'=> 9,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'amicizia',
			    'tipoID' => 3,
			    'letta' => 0,
			),
			array(
			    'notificaID'=> 10,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'utenteID' => 1,
			    'tipo' => 'commento',
			    'tipoID' => 2,
			    'letta' => 1,
			),
	));

    }
}
