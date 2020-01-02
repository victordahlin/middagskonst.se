<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            App\Products::create([
                'title' => Str::random(10),
                "dinners" => 4,
                "persons" => 4,
                "longText" => Str::random(10),
                "summaryText" => Str::random(10),
                "addonsText" => Str::random(10),
                "text" => "Text",
                "img" => "fredagspåse_web.jpg",
                "price" => "399",
                "discount" => "10",
                "type" => "bags",
                "reference" => "reference"
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            App\Products::create([
                'title' => Str::random(10),
                "dinners" => 4,
                "persons" => 4,
                "longText" => Str::random(10),
                "summaryText" => Str::random(10),
                "addonsText" => Str::random(10),
                "text" => "Text",
                "img" => "fredagspåse_web.jpg",
                "price" => "499",
                "discount" => "10",
                "type" => "alternativeBags",
                "reference" => "reference"
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            App\Products::create([
                'title' => Str::random(10),
                "dinners" => 4,
                "persons" => 4,
                "longText" => Str::random(10),
                "summaryText" => Str::random(10),
                "addonsText" => Str::random(10),
                "text" => "Text",
                "img" => "fredagspåse_web.jpg",
                "price" => "599",
                "discount" => "10",
                "type" => "extra",
                "reference" => "reference"
            ]);
        }
    }
}
