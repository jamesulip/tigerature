<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\questions;

class questionsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_questions()
    {
        $questions = factory(questions::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/questions', $questions
        );

        $this->assertApiResponse($questions);
    }

    /**
     * @test
     */
    public function test_read_questions()
    {
        $questions = factory(questions::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/questions/'.$questions->id
        );

        $this->assertApiResponse($questions->toArray());
    }

    /**
     * @test
     */
    public function test_update_questions()
    {
        $questions = factory(questions::class)->create();
        $editedquestions = factory(questions::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/questions/'.$questions->id,
            $editedquestions
        );

        $this->assertApiResponse($editedquestions);
    }

    /**
     * @test
     */
    public function test_delete_questions()
    {
        $questions = factory(questions::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/questions/'.$questions->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/questions/'.$questions->id
        );

        $this->response->assertStatus(404);
    }
}
