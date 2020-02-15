<?php

use Illuminate\Database\Seeder;
use App\House;
use App\Tenant; 

class HouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant_a = Tenant::where('email', 'toyo@gmail.com')->first();
        $tenant_b = Tenant::where('email', 'kim@gmail.com')->first();

        $house = new House();
        $house->house_no = 'A1';
        $house->features = '3 Bedroom Bungalow Open-Kitchen Plan Dinning Room';
        $house->rent = '50000';
        $house->status = 'occipied';
        $house->water_meter_no = rand(100000,999999);
        $house->electricity_meter_no = rand(100000,999999);
        $house->tenant_id = $tenant_a->id;
        $house->save();

        $house = new House();
        $house->house_no = 'A2';
        $house->features = '4 Bedroom Bungalow, With Garage & SQ';
        $house->rent = '60000';
        $house->status = 'occipied';
        $house->water_meter_no = rand(100000,999999);
        $house->electricity_meter_no = rand(100000,999999);
        $house->tenant_id = $tenant_b->id;
        $house->save();
    }
}
