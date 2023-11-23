<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $commentCount = rand(0, 4);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Comment::factory(1)->create(['blog_post_id' => 1]);
        // Author::factory(1)->create();
        Author::factory(1)->has(Profile::factory())->create();
        BlogPost::factory(1)->has(Comment::factory($commentCount))->create();
    }
}
