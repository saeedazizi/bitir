<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\JWTAuth;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private string $token;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::find(11);
        $this->token = $this->app->make(JWTAuth::class)->attempt(['email' => $user->email, 'password' => 'password']);
    }

    public function testShowTask(): void
    {
        $response = $this->get(
            '/graphql?query={task(id:11){id,title,content,user{id,email}}}',
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertStatus(200);
    }

    public function testShowTasks(): void
    {
        $response = $this->get(
            '/graphql?query={tasks{id,title,content,user{id,email}}}',
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertStatus(200);
    }

    public function testCreateTask(): void
    {
        $response = $this->post(
            '/graphql',
            ['query' => 'mutation {createTask(title: "test",content: "test"){id, title, content}}'],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertStatus(200);
    }

    public function testUpdateTask(): void
    {
        $response = $this->post(
            '/graphql',
            ['query' => 'mutation {updateTask(id: 11,title: "test",content: "test"){id, title, content}}'],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertStatus(200);
    }

    public function testDeleteTask(): void
    {
        $response = $this->post(
            '/graphql',
            ['query' => 'mutation {deleteTask(id:11)}'],
            ['Authorization' => 'Bearer ' . $this->token]
        );

        $response->assertStatus(200);
        $response->assertExactJson(['data' => ['deleteTask' => true]]);
    }
}
