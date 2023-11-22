<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase {
    public function testHomePageIsWorkingCorrectly(): void {
        $response = $this->get('/');

        $response->assertSeeText('Welcome to Laravel!');
        $response->assertSeeText('This is the content of the main page!');
    }

    public function testContactPageIsWorkingCorrectly(): void {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact page');
    }
}
