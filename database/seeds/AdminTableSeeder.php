<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\User;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name','John Doe')->first();

        $admin = new Admin();
        $admin->surname = 'Doe';
        $admin->other_names = 'John';
        $admin->gender = 'male';
        $admin->national_id = '3526268520';
        $admin->phone_no = '254748956230';
        $admin->email = 'admin@example.com';
        $admin->user_id = $user->id;
        $admin->save();
    }
}
