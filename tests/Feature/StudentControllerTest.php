<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentControllerTest extends TestCase
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

    public function test_get_all_students()
    {
        // Create some test data
        Student::factory(3)->create();

        // Make a GET request to the endpoint
        $response = $this->get('/api/students');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is correct
        // Change the assertion to include only the 'name' key
        $response->assertJsonStructure([
            '*' => ['name', 'age', 'created_at', 'updated_at'],
        ]);


        // Assert that the correct number of students is returned
        $response->assertJsonCount(3);
    }

    // Add tests for other CRUD operations
}
