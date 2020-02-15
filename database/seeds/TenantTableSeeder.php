<?php

use Illuminate\Database\Seeder;
use \App\Tenant;

class TenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = new Tenant();
        $tenant->surname = 'Toyo';
        $tenant->other_names = 'Moto';
        $tenant->gender = 'male';
        $tenant->national_id = '3456258595';
        $tenant->phone_no = '254789652366';
        $tenant->email = 'toyo@gmail.com';
        $tenant->save();

        $tenant = new Tenant();
        $tenant->surname = 'Kim';
        $tenant->other_names = 'Poi';
        $tenant->gender = 'female';
        $tenant->national_id = '3456258533';
        $tenant->phone_no = '254789652333';
        $tenant->email = 'kim@gmail.com';
        $tenant->save();
    }
}
