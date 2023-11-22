<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase {
    use RefreshDatabase;

    private function createDummyBlogPost(): BlogPost {
        $post = new BlogPost();
        $post->title = 'My title';
        $post->content = 'My content';
        $post->save();

        return $post;
    }

    public function testNoBlogPostWhenNothingInDatabase(): void {
        $response = $this->get('/posts');

        $response->assertSeeText('There are no posts');
    }

    public function testBlogPostWhenSomethingInDatabase(): void {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('My title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'My title',
        ]);
    }

    public function testBlogPostCanBeStored(): void {
        $params = [
            'title' => 'Valid title',
            'content' => 'Valid content more than 10 char',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail(): void {
        $params = [
            'title' => '',
            'content' => '',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title field is required.');
        $this->assertEquals($messages['content'][0], 'The content field is required.');
    }

    public function testBlogPostCanBeUpdated(): void {
        // Arrange
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'My title',
        ]);

        $params = [
            'title' => 'A new title',
            'content' => 'Content was changed',
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());

    }

    public function testBlogPostCanBeDeleted(): void {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'My title',
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }
}
