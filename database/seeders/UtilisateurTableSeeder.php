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
            'photo' => 'default.jpg',
            'birthdate' => '1990-01-01',
            'est_admin' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
