<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\password_resets;

class password_resetsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_password_resets()
    {
        $passwordResets = factory(password_resets::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/password_resets', $passwordResets
        );

        $this->assertApiResponse($passwordResets);
    }

    /**
     * @test
     */
    public function test_read_password_resets()
    {
        $passwordResets = factory(password_resets::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/password_resets/'.$passwordResets->id
        );

        $this->assertApiResponse($passwordResets->toArray());
    }

    /**
     * @test
     */
    public function test_update_password_resets()
    {
        $passwordResets = factory(password_resets::class)->create();
        $editedpassword_resets = factory(password_resets::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/password_resets/'.$passwordResets->id,
            $editedpassword_resets
        );

        $this->assertApiResponse($editedpassword_resets);
    }

    /**
     * @test
     */
    public function test_delete_password_resets()
    {
        $passwordResets = factory(password_resets::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/password_resets/'.$passwordResets->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/password_resets/'.$passwordResets->id
        );

        $this->response->assertStatus(404);
    }
}
