<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Payment;
use App\Tenant;
use App\Invoice;

class PaymentTableSeeder extends Seeder
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

        $invoice_a = Invoice::where('id', '1')->first();
        $invoice_b = Invoice::where('id', '2')->first();

        $array_payment_type = array('cash', 'cheque', 'mpesa', 'paypal');

        $faker = Factory::create();

        for ($i = 0; $i < 2; $i++) {
            $payment_a = new Payment();
            $payment_a->tenant_id = $tenant_a->id;
            $payment_a->invoice_id = $invoice_a->id;
            $payment_a->payment_type = $faker->randomElement($array_payment_type);
            $payment_a->payment_date = $faker->date();
            $payment_a->payment_no = $faker->numberBetween(1000, 2000);
            $payment_a->prev_balance = $faker->numberBetween(1000, 10000);
            $payment_a->amount_paid = $faker->numberBetween(1000, 10000);
            $payment_a->balance = $faker->numberBetween(1000, 5000);
            $payment_a->comments = $faker->sentence;
            $payment_a->save();

            $payment_b = new Payment();
            $payment_b->tenant_id = $tenant_b->id;
            $payment_b->invoice_id = $invoice_b->id;
            $payment_b->payment_type = $faker->randomElement($array_payment_type);
            $payment_b->payment_date = $faker->date();
            $payment_b->payment_no = $faker->numberBetween(1000, 2000);
            $payment_b->prev_balance = $faker->numberBetween(1000, 10000);
            $payment_b->amount_paid = $faker->numberBetween(1000, 10000);
            $payment_b->balance = $faker->numberBetween(1000, 5000);
            $payment_b->comments = $faker->sentence;
            $payment_b->save();
        }
    }
}
