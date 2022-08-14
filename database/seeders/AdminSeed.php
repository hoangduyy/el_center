<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->truncate();

        Admin::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'role' => "admin",
            'password' => Hash::make('123456'),
        ]);

        Admin::create([
            'name' => "Manager",
            'email' => "manager@gmail.com",
            'role' => "manage",
            'password' => Hash::make('123456'),
        ]);
    }
}
