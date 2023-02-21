<?php

namespace Database\Seeders;

use App\Models\Pays;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin Seeder
        $user = User::create([
            'pays_register_id'  => Pays::where('indicatif', "+225")->first()->id,
            'ip_register'       => '160.154.156.144',
            'email' => 'admin@laraveltuts.com',
            'password' => bcrypt('password'),
            'recent_ip'         => '160.154.156.144',
            'telephone'         => '+2250789482126',

        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
