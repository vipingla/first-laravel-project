<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;
use Faker\Factory as Faker;

class UserdatasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $arrayValues = ['php', 'python', 'java'];
        // // \App\Models\User::factory(10)->create();
        // DB::table('userdatas')->insert([
        //     'name'=>str::random(10),
        //     'skills'=>str::random(10).', '.str::random(10),
        //     'expertise'=>$arrayValues[rand(0,2)]
        // ]);

        $faker = Faker::create();
        $arrayValues = ['php', 'python', 'java'];
    	foreach (range(1,12) as $index) {
            DB::table('userdatas')->insert([
                'name' => $faker->name,
                'skills' => $faker->text,
                'expertise'=>$arrayValues[rand(0,2)]
            ]);
        }
    }
}
