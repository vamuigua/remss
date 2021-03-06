<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\User;
use \App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'User')->first();
        $role_admin = Role::where('name', 'Admin')->first();

        $user = new User();
        $user->name = 'Toyo Moto';
        $user->email = 'user@example.com';
        $user->password = Hash::make('user');
        $user->save();
        $user->roles()->attach($role_user);

        $user2 = new User();
        $user2->name = 'Kim Poi';
        $user2->email = 'user2@example.com';
        $user2->password = Hash::make('user2');
        $user2->save();
        $user2->roles()->attach($role_user);

        $admin = new User();
        $admin->name = 'John Doe';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('admin');
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
