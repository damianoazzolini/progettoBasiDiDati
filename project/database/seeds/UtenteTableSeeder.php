<?php

use Illuminate\Database\Seeder;

class UtenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	
        DB::table('utente')->insert(array(
			array(
			    'utenteID'=> 1,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'nome' => 'Ilaria',
			    'cognome' => 'Sassoli',
			    'email' => 'ilaria.sassoli@student.unife.it',
			    'password' => bcrypt('admin'),
			    'attivo' => 1,
			    'dataNascita' => '1994-12-01',
			    'sesso' => 1,
			    'immagine' => '/systemImages/defaultUserImage.svg',
			    'codice' => substr(md5(uniqid(mt_rand(), true)) , 0, 32)
			),
			array(
			    'utenteID'=> 2,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'nome' => 'Damiano',
			    'cognome' => 'Azzolini',
			    'email' => 'damiano.azzolini@student.unife.it',
			    'password' => bcrypt('admin'),
			    'attivo' => 1,
			    'dataNascita' => '1994-12-30',
			    'sesso' => 0,
			    'immagine' => '/systemImages/defaultUserImage.svg',
			    'codice' => substr(md5(uniqid(mt_rand(), true)) , 0, 32)
			),
			array(
			    'utenteID'=> 3,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'nome' => 'Mattia',
			    'cognome' => 'Fazzi',
			    'email' => 'mattia.fazzi@student.unife.it',
			    'password' => bcrypt('admin'),
			    'attivo' => 1,
			    'dataNascita' => '1994-10-10',
			    'sesso' => 0,
			    'immagine' => '/systemImages/defaultUserImage.svg',
			    'codice' => substr(md5(uniqid(mt_rand(), true)) , 0, 32)
			),
			array(
			    'utenteID'=> 4,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'nome' => 'Alessandro',
			    'cognome' => 'Bertagnon',
			    'email' => 'alessandro.bertagnon@student.unife.it',
			    'password' => bcrypt('admin'),
			    'attivo' => 1,
			    'dataNascita' => '1994-02-23',
			    'sesso' => 0,
			    'immagine' => '/systemImages/defaultUserImage.svg',
			    'codice' => substr(md5(uniqid(mt_rand(), true)) , 0, 32)
			),
			array(
			    'utenteID'=> 5,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'nome' => 'Dario',
			    'cognome' => 'Decarlo',
			    'email' => 'dario.decarlo@student.unife.it',
			    'password' => bcrypt('admin'),
			    'attivo' => 1,
			    'dataNascita' => '1994-01-01',
			    'sesso' => 0,
			    'immagine' => '/systemImages/defaultUserImage.svg',
			    'codice' => substr(md5(uniqid(mt_rand(), true)) , 0, 32)
			),
			array(
			    'utenteID'=> 6,
			    'created_at' => now(),
			    'updated_at'=> now(),
			    'nome' => 'Francesco',
			    'cognome' => 'Bertasi',
			    'email' => 'francesco.bertasi@student.unife.it',
			    'password' => bcrypt('admin'),
			    'attivo' => 1,
			    'dataNascita' => '1994-01-01',
			    'sesso' => 0,
			    'immagine' => '/systemImages/defaultUserImage.svg',
			    'codice' => substr(md5(uniqid(mt_rand(), true)) , 0, 32)
			)
	));
    }
}
