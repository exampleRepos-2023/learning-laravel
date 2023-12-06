<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $tagCount = Tag::all()->count();

        if(0 === $tagCount) {
            $this->command->info("No tags found. skipping tags to blog posts");
            return;
        }

        $howManyMin = (int)$this->command
            ->ask("Min tags assigned to blog posts?", 0);
        $howManyMax = min((int)$this->command
            ->ask("Max tags assigned to blog posts", $tagCount), $tagCount);

        // Loop through each blog post and assign random tags within the specified range
        BlogPost::all()->each(function (BlogPost $posts) use ($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck("id");

            // Sync the tags with the blog post
            $posts->tags()->sync($tags);
        });
    }
}
