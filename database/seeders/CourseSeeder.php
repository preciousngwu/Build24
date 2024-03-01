<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            "user_id"     => 1,
            "title"       => "Web development",
            "signup_link" => "https:://webdevelopment",
            "summary"     => "Learn all you need to know about web development",
            "created_at"  => now(),
            "updated_at"  => now(),
        ]);

        DB::table('courses')->insert([
            "user_id"     => 1,
            "title"       => "Backend development",
            "signup_link" => "https:://loveyou",
            "summary"     => "Learn all you need to know about web development",
            "created_at"  => now(),
            "updated_at"  => now(),
        ]);
    }
}
