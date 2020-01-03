<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DinnerMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++) {
            App\DinnerMenu::create([
                'title' => "Melanders",
                'starter' => Str::random(10),
                'main' => Str::random(10),
                'dessert' => Str::random(10),
                'week' => Str::random(10),
            ]);
        }

        for($i = 0; $i < 10; $i++) {
            App\DinnerMenu::create([
                'title' => "WinBladhs",
                'starter' => Str::random(10),
                'main' => Str::random(10),
                'dessert' => Str::random(10),
                'week' => Str::random(10),
            ]);
        }

        for($i = 0; $i < 10; $i++) {
            App\DinnerMenu::create([
                'title' => "saluhalls",
                'starter' => Str::random(10),
                'main' => Str::random(10),
                'dessert' => Str::random(10),
                'week' => Str::random(10),
            ]);
        }
    }
}
