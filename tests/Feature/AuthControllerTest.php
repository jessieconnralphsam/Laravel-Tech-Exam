<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_register_a_user()
    {
        $strongPassword = 'P@ssw0rd!2024';
        $email = $this->faker->unique()->safeEmail;

        $response = $this->postJson('/api/register', [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => $strongPassword,
            'password_confirmation' => $strongPassword,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'user' => [
                         'id',
                         'name',
                         'email',
                         'created_at',
                         'updated_at',
                     ],
                     'token'
                 ]);

        $this->assertDatabaseHas('users', ['email' => $email]);
        
        $this->assertEquals($email, $response->json('user.email'));
    }
}