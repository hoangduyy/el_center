<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Degree;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DegreeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('degrees')->truncate();

        for ($i = 1; $i < 6; $i++) {
            Degree::create([
                'name' => "Học vị $i",
                'description' => "Học vị $i",
            ]);
        }
    }
}
