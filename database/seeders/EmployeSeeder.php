<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employe::create([
            'user_id'  => User::where('indicatif', "+225")->first()->id,
            'nom'       => '160.154.156.144',
            'prenom'             => 'boubacarly93@gmail.com',
            'telephone' => now(),
            'email'         => '+admin@lisocash.com',
            'ville'         => 'Paris',

        ]);
    }
}
