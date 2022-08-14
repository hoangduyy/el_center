<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QuestionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::truncate();

        $da = ['a', 'b', 'c', 'd'];

        $faker = \Faker\Factory::create('vi_VN');
        for ($i = 0; $i < 998; $i++) {
            $item = [
                'question' => $faker->text(200),
                'da_a' => $faker->text(64),
                'da_b' => $faker->text(64),
                'da_c' => $faker->text(64),
                'da_d' => $faker->text(64),
                'da' => $da[(rand(0,3))],
            ];

            Question::create($item);
        }
    }
}
