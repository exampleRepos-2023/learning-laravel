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
        // $posts = BlogPost::factory(20)->has(Comment::factory($commentCount))->create();

        if ($this->command->confirm('Do you want to refresh the database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed!');
        }
        // clear the cache
        Cache::tags(['blog-post'])->flush();

        // Author::factory(20)->has(Profile::factory())->create();

        User::factory()->adminNeco()->create();
        User::factory(20)->create();
        $users = User::all();

        $posts = BlogPost::factory(50)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $comments = Comment::factory(150)->make()
            ->each(function ($comment) use ($posts, $users) {
                $comment->blog_post_id = $posts->random()->id;
                $comment->user_id = $users->random()->id;
                $comment->save();
            });


        $this->call([
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
        ]);
    }
}
