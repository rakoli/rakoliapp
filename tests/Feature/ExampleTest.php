<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_are_redirected_to_login_page()
    {
        // Arrange
        $response = $this->get('/');

        // Assert
        $response->assertRedirect('/login');
    }

}
