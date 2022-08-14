<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Certificate;
use App\Models\Degree;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CertificateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('certificates')->truncate();

        for ($i = 1; $i < 10; $i++) {
            Certificate::create([
                'name' => "Chứng chỉ $i",
                'description' => "Chứng chỉ $i",
            ]);
        }
    }
}
