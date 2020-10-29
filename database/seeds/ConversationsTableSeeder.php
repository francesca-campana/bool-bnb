<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Conversation;


class ConversationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 15; $i++) {
          $new_conversation = new Conversation();
          $new_conversation->message = $faker->sentence(150);
          $new_conversation->email = $faker->email;
          $new_conversation->date = $faker->date;
          $new_conversation->apartment_id = rand(1,5);
          $new_conversation->save();
        }
    }
}
