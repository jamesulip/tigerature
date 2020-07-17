<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\migrations;

class migrationsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_migrations()
    {
        $migrations = factory(migrations::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/migrations', $migrations
        );

        $this->assertApiResponse($migrations);
    }

    /**
     * @test
     */
    public function test_read_migrations()
    {
        $migrations = factory(migrations::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/migrations/'.$migrations->id
        );

        $this->assertApiResponse($migrations->toArray());
    }

    /**
     * @test
     */
    public function test_update_migrations()
    {
        $migrations = factory(migrations::class)->create();
        $editedmigrations = factory(migrations::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/migrations/'.$migrations->id,
            $editedmigrations
        );

        $this->assertApiResponse($editedmigrations);
    }

    /**
     * @test
     */
    public function test_delete_migrations()
    {
        $migrations = factory(migrations::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/migrations/'.$migrations->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/migrations/'.$migrations->id
        );

        $this->response->assertStatus(404);
    }
}
