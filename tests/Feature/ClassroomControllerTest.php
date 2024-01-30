<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Classroom;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $user = User::factory()->create();

        // Authenticate the user and get the JWT token
        $token = JWTAuth::fromUser($user);

        // Include the JWT token in the request headers
        $this->withHeader('Authorization', 'Bearer ' . $token);
    }

    public function test_get_all_classrooms()
    {
        // Create some test data
        Classroom::factory(3)->create();

        // Make a GET request to the endpoint
        $response = $this->get('/api/classrooms');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is correct
        // Change the assertion to include only the 'name' key
        $response->assertJsonStructure([
            '*' => ['name', 'capacity', 'students', 'teachers', 'created_at', 'updated_at'],
        ]);

        // Assert that the correct number of classrooms is returned
        $response->assertJsonCount(3);
    }

    // Add tests for other CRUD operations and relationships
}
