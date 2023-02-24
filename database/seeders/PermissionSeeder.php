<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'consultation-statistiques']);

        Permission::create(['name' => 'liste-client']);
        Permission::create(['name' => 'ajout_client']);
        Permission::create(['name' => 'modification-client']);
        Permission::create(['name' => 'suppression-client']);

        Permission::create(['name' => 'liste-utilisateur']);
        Permission::create(['name' => 'ajout_utilisateur']);
        Permission::create(['name' => 'modification-utilisateur']);
        Permission::create(['name' => 'suppression-utilisateur']);

        Permission::create(['name' => 'liste-distributeur']);
        Permission::create(['name' => 'ajout_distributeur']);
        Permission::create(['name' => 'modification-distributeur']);
        Permission::create(['name' => 'suppression-distributeur']);
        
    }
}
