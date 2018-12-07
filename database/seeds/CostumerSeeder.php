<?php

use Illuminate\Database\Seeder;
use App\Models\Costumer;

class CostumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Costumer::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Costumer::create([
                'name' => $faker->name,
                'phone' => $faker->sentence,
                'Type' => $faker->sentence,
                'city' => $faker->sentence,
                'adress' => $faker->sentence,
                'contact' => $faker->sentence,
                'contact_phone' => $faker->sentence,
                'created_by' => 1,
            ]);
        }
    }
}
