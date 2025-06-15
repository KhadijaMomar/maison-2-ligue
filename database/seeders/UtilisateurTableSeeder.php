<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UtilisateurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('utilisateur')->insert([
            'name' => 'Khadija',
            'surname' => 'Ndiour',
            'email' => 'sirtaf@gmail.com',
            'password' => bcrypt('dija123'), 
            'city' => 'Paris',
            'country' => 'France',
            'phone' => '0601020304',
            'photo' => 'personne2.avif',
            'birthdate' => '1990-01-01',
            'est_admin' => true,
            'civilite' => 'Femme',
            'categorie' => 'Client',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('utilisateur')->insert([
            'name' => 'Tafsir',
            'surname' => 'Ndiour',
            'email' => 'dija@gmail.com',
            'password' => bcrypt('sirtaf123'), 
            'city' => 'Paris',
            'country' => 'France',
            'phone' => '0701820204',
            'photo' => 'personne1.jpg',
            'birthdate' => '1997-02-10',
            'est_admin' => false,
            'civilite' => 'Homme',
            'categorie' => 'Marcketing',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('utilisateur')->insert([
            'name' => 'Fatou',
            'surname' => 'ba',
            'email' => 'fatou.ba@gmail.com',
            'password' => bcrypt('fatou123'), 
            'city' => 'Paris',
            'country' => 'France',
            'phone' => '0781920204',
            'photo' => 'personne7.avif',
            'birthdate' => '2020-02-10',
            'est_admin' => false,
            'civilite' => 'Femme',
            'categorie' => 'Informatique',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('utilisateur')->insert([
            'name' => 'Aida',
            'surname' => 'Diallo',
            'email' => 'aida.diallo@gmail.com',
            'password' => bcrypt('aida123'), 
            'city' => 'Paris',
            'country' => 'France',
            'phone' => '0701820204',
            'photo' => 'personne4.avif',
            'birthdate' => '1997-02-10',
            'est_admin' => false,
            'civilite' => 'Homme',
            'categorie' => 'Technique',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
