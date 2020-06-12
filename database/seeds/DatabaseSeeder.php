<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(TenantTableSeeder::class);
        $this->call(HouseTableSeeder::class);
        $this->call(InvoiceTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
        $this->call(ExpenditureTableSeeder::class);
    }
}
