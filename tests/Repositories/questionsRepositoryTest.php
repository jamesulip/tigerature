<?php namespace Tests\Repositories;

use App\Models\questions;
use App\Repositories\questionsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class questionsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var questionsRepository
     */
    protected $questionsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->questionsRepo = \App::make(questionsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_questions()
    {
        $questions = factory(questions::class)->make()->toArray();

        $createdquestions = $this->questionsRepo->create($questions);

        $createdquestions = $createdquestions->toArray();
        $this->assertArrayHasKey('id', $createdquestions);
        $this->assertNotNull($createdquestions['id'], 'Created questions must have id specified');
        $this->assertNotNull(questions::find($createdquestions['id']), 'questions with given id must be in DB');
        $this->assertModelData($questions, $createdquestions);
    }

    /**
     * @test read
     */
    public function test_read_questions()
    {
        $questions = factory(questions::class)->create();

        $dbquestions = $this->questionsRepo->find($questions->id);

        $dbquestions = $dbquestions->toArray();
        $this->assertModelData($questions->toArray(), $dbquestions);
    }

    /**
     * @test update
     */
    public function test_update_questions()
    {
        $questions = factory(questions::class)->create();
        $fakequestions = factory(questions::class)->make()->toArray();

        $updatedquestions = $this->questionsRepo->update($fakequestions, $questions->id);

        $this->assertModelData($fakequestions, $updatedquestions->toArray());
        $dbquestions = $this->questionsRepo->find($questions->id);
        $this->assertModelData($fakequestions, $dbquestions->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_questions()
    {
        $questions = factory(questions::class)->create();

        $resp = $this->questionsRepo->delete($questions->id);

        $this->assertTrue($resp);
        $this->assertNull(questions::find($questions->id), 'questions should not exist in DB');
    }
}
