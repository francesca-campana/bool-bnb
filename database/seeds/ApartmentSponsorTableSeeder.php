<?php

use Illuminate\Database\Seeder;

class ApartmentSponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('apartment_sponsor')->insert([
        [
        'apartment_id' => 34,
        'sponsor_id' => 1,
        'inizio_sponsorizzazione' => '2020-03-23 09:40:18',
        'fine_sponsorizzazione' => '2020-03-23 09:40:18',
        'status_payment' => 'approvato',
        ]
      ]);

      DB::table('apartment_sponsor')->insert([
        [
        'apartment_id' => 35,
        'sponsor_id' => 2,
        'inizio_sponsorizzazione' => '2020-03-23 09:40:18',
        'fine_sponsorizzazione' => '2020-03-23 09:40:18',
        'status_payment' => 'approvato',
        ]
      ]);

      DB::table('apartment_sponsor')->insert([
        [
        'apartment_id' => 36,
        'sponsor_id' => 2,
        'inizio_sponsorizzazione' => '2020-03-23 09:40:18',
        'fine_sponsorizzazione' => '2020-03-23 09:40:18',
        'status_payment' => 'approvato',
        ]
      ]);

      DB::table('apartment_sponsor')->insert([
        [
        'apartment_id' => 37,
        'sponsor_id' => 3,
        'inizio_sponsorizzazione' => '2020-03-23 09:40:18',
        'fine_sponsorizzazione' => '2020-03-23 09:40:18',
        'status_payment' => 'approvato',
        ]
      ]);
    }
}
