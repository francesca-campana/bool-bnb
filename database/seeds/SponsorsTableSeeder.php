<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Sponsor;

class SponsorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors_types = [
          [
                'name' => 'bronze',
                'price' => 2.99,
                'duration' => 24,
            ],
            [
                'name' => 'silver',
                'price' => 5.99,
                'duration' => 72,
            ],
            [
                'name' => 'gold',
                'price' => 9.99,
                'duration' => 144,
            ]
        ];
        foreach ($sponsors_types as $sponsors_type) {
          $new_sponsors_type = new Sponsor();
          $new_sponsors_type->name = $sponsors_type['name'];
          $new_sponsors_type->price = $sponsors_type['price'];
          $new_sponsors_type->duration = $sponsors_type['duration'];

          $new_sponsors_type->save();
        }
    }
}
