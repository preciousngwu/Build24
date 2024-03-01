<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->insert([
            "course_id"  => 1,
            "title"      => "Beginner",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
