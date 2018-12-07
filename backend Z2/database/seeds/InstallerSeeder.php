<?php

use App\Models\Installer;
use Illuminate\Database\Seeder;

class InstallerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Installer::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Installer::create([


                'fisrt_name'=>$faker->name,
                'last_name'=> $faker->name,
                'phone'=> $faker->sentence,
                'mail'=> $faker->sentence,
                'cin'=> $faker->sentence
            ]);
        }
    }
}
