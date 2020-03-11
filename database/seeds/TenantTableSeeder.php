<?php

use Illuminate\Database\Seeder;
use \App\Tenant;
use \App\User;

class TenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::where('name', 'User')->first();
        $user2 = User::where('name', 'User2')->first();

        $tenant = new Tenant();
        $tenant->surname = 'Toyo';
        $tenant->other_names = 'Moto';
        $tenant->gender = 'male';
        $tenant->national_id = '3456258595';
        $tenant->phone_no = '254789652366';
        $tenant->email = 'toyo@gmail.com';
        $tenant->user_id = $user1->id;
        $tenant->save();

        $tenant = new Tenant();
        $tenant->surname = 'Kim';
        $tenant->other_names = 'Poi';
        $tenant->gender = 'female';
        $tenant->national_id = '3456258533';
        $tenant->phone_no = '254789652333';
        $tenant->email = 'kim@gmail.com';
        $tenant->user_id = $user2->id;
        $tenant->save();
    }
}
