<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Invoice;
use App\InvoiceProduct;
use App\Tenant; 

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant_a = Tenant::where('id', '1')->first();
        $tenant_b = Tenant::where('id', '2')->first();
        $array_names = array($tenant_a->surname, $tenant_b->surname);
        $array_address = array($tenant_a->email, $tenant_b->email);

        $faker = Factory::create();

        Invoice::truncate();
        InvoiceProduct::truncate();

        foreach(range(1, 2) as $i) {
            $products = collect();
            foreach(range(1, mt_rand(2, 10)) as $j) {
                $unitPrice = $faker->numberBetween(100, 1000);
                $qty = $faker->numberBetween(1, 20);
                $products->push(new InvoiceProduct([
                    'name' => $faker->sentence,
                    'price' => $unitPrice,
                    'qty' => $qty,
                    'total' => ($qty  * $unitPrice)
                ]));

            }

            $subTotal = $products->sum('total');
            $discount = $faker->numberBetween(10, 20);
            $total = $subTotal - $discount;

            $invoice = Invoice::create([
                'tenant_id' => $faker->numberBetween($tenant_a->id, $tenant_b->id),
                'client_address' => $faker->randomElement($array_address),
                'title' => $faker->sentence,
                'invoice_no' => $faker->numberBetween(1000, 2000),
                'invoice_date' => $faker->date(),
                'due_date' => $faker->date(),
                'discount' => $discount,
                'sub_total' => $subTotal,
                'grand_total' => $total,
                'status' => 'active'
            ]);

            $invoice->products()->saveMany($products);
        }
    }
}
