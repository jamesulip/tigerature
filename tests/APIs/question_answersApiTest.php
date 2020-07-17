<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\question_answers;

class question_answersApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/question_answers', $questionAnswers
        );

        $this->assertApiResponse($questionAnswers);
    }

    /**
     * @test
     */
    public function test_read_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/question_answers/'.$questionAnswers->id
        );

        $this->assertApiResponse($questionAnswers->toArray());
    }

    /**
     * @test
     */
    public function test_update_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->create();
        $editedquestion_answers = factory(question_answers::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/question_answers/'.$questionAnswers->id,
            $editedquestion_answers
        );

        $this->assertApiResponse($editedquestion_answers);
    }

    /**
     * @test
     */
    public function test_delete_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/question_answers/'.$questionAnswers->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/question_answers/'.$questionAnswers->id
        );

        $this->response->assertStatus(404);
    }
}
