<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	 DB::table('amicizia')->delete();
	 DB::table('commento')->delete();
	 DB::table('media')->delete();
	 DB::table('reazione')->delete();
	 DB::table('notifica')->delete();
	 DB::table('post')->delete();
	 DB::table('utente')->delete();
	
         $this->call('UtenteTableSeeder');
	 $this->call('PostTableSeeder');
	 $this->call('NotificaTableSeeder');
         $this->call('ReazioneTableSeeder');
	 $this->call('MediaTableSeeder');
	 $this->call('CommentoTableSeeder');
 	 $this->call('AmiciziaTableSeeder');
         
    }
}
