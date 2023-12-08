<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        if ($this->command->confirm('Do you want to refresh the database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed!');
        }
        // clear the cache
        Cache::tags(['blog-post'])->flush();

        User::factory()->adminNeco()->create();
        User::factory(20)->create();
        $users = User::all();

        $posts = BlogPost::factory(50)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });

        Comment::factory(150)->make()
            ->each(function ($comment) use ($posts, $users) {
                $comment->commentable_id   = $posts->random()->id;
                $comment->commentable_type = BlogPost::class;
                $comment->user_id          = $users->random()->id;
                $comment->save();
            });

        Comment::factory(150)->make()
            ->each(function ($comment) use ($users) {
                $comment->commentable_id   = $users->random()->id;
                $comment->commentable_type = User::class;
                $comment->user_id          = $users->random()->id;
                $comment->save();
            });


        $this->call([
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
        ]);
    }
}
