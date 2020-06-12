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
        $user1 = User::where('name', 'Toyo Moto')->first();
        $user2 = User::where('name', 'Kim Poi')->first();

        $tenant = new Tenant();
        $tenant->surname = 'Moto';
        $tenant->other_names = 'Toyo';
        $tenant->gender = 'male';
        $tenant->national_id = '3456258595';
        $tenant->phone_no = '254789652366';
        $tenant->email = 'user@gmail.com';
        $tenant->user_id = $user1->id;
        $tenant->save();

        $tenant = new Tenant();
        $tenant->surname = 'Poi';
        $tenant->other_names = 'Kim';
        $tenant->gender = 'female';
        $tenant->national_id = '3456258533';
        $tenant->phone_no = '254789652333';
        $tenant->email = 'user2@gmail.com';
        $tenant->user_id = $user2->id;
        $tenant->save();
    }
}
