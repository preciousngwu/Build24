<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            "name"       => "demo demo",
            "email"      => 'demo@demo.com',
            "password"   => Hash::make('12345678'),
            "account"    => 1,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('users')->insert([
            "name"       => "student bassey",
            "email"      => 'bassey@demo.com',
            "password"   => Hash::make('12345678'),
            "account"    => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('users')->insert([
            "name"       => "student okon",
            "email"      => 'okon@demo.com',
            "password"   => Hash::make('12345678'),
            "account"    => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

    }
}
