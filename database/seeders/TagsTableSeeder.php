<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $tags = collect(['Science', 'Technology', 'Design', 'Culture', 'Art', 'Food', 'Sport']);

        foreach($tags as $tagName) {
            $tag = new Tag();
            $tag->name = $tagName;
            $tag->save();
        }

    }
}
