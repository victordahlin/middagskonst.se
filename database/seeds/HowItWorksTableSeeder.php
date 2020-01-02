<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HowItWorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 50; $i++) {
            App\HowItWorks::create([
                'title' => Str::random(10),
                "text" => Str::random(10)
            ]);
        }
    }
}
