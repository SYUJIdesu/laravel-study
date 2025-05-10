<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
        {
        // 外部キー制約を一時的に無効にする
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Post::truncate();
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@text.com',
            'password' => Hash::make('password'),
        ]);

        Post::factory()->count(10)->create();
    }
}
