<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Faker\Factory::create('ja_JP');
        
        for($i=0;$i<10;$i++){
            App\Book::create([
                'item_name' => $faker->word(),
                'user_id' => $faker->numberBetween(1,2),
                'item_number' => $faker->numberBetween(1,999),
                'item_amount' => $faker->numberBetween(100,5000),
                'item_img' => $faker->image('./public/upload',300,300,'cats',false),
                'published' => $faker->dateTime('now'),
                'created_at' => $faker->dateTime('now'),
                'updated_at' => $faker->dateTime('now')
            ]);
        }
    }
}
