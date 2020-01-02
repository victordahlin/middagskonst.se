<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DinnerBagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            App\DinnerBags::create([
                'title' => Str::random(10),
                "text" => Str::random(10)
            ]);
        }
    }
}
