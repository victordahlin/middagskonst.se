<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StartPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            App\StartPage::create([
                'title' => Str::random(10),
                "text" => Str::random(10),
            ]);
        }
    }
}
