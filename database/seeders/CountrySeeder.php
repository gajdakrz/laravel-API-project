<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CountrySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Country::insert(
            array(
                array('name'=>'Polska', 'country'=> 'PL', 'rate_per_day'=>'10.00'),
                array('name'=>'Niemcy', 'country'=> 'DE', 'rate_per_day'=>'50.00'),
                array('name'=>'Wielka Brytania', 'country'=> 'GB', 'rate_per_day'=>'75.00'),
            )
        );
    }
}
