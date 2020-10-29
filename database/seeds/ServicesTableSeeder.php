<?php

use Illuminate\Database\Seeder;

use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $services = [
        'Wifi',
        'Parcheggio',
        'Animali ammessi',
        'Aria condizionata',
        'Piscina',
        'Lavatrice',
        'Tv',
        'Cucina',
        'Colazione',
      ];
      foreach ($services as $service) {
        $new_service = new Service();
        $new_service->name = $service;
        $new_service->save();
      }
    }
}
