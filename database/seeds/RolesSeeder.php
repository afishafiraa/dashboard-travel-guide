<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        
        Role::create(['name' => 'guide']);
        Role::create(['name' => 'merchant']);
        /** @var \App\User $user */
        $user = factory(\App\User::class)->create();
        $user->assignRole('guide');

        $user = factory(\App\User::class)->create();
        $user->assignRole('merchant');
        
        Role::create(['name' => 'admin']);

        /** @var \App\User $user */
        $admin = factory(\App\User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');
    }
}
