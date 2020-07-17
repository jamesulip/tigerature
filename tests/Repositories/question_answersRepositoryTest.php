<?php namespace Tests\Repositories;

use App\Models\question_answers;
use App\Repositories\question_answersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class question_answersRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var question_answersRepository
     */
    protected $questionAnswersRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->questionAnswersRepo = \App::make(question_answersRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->make()->toArray();

        $createdquestion_answers = $this->questionAnswersRepo->create($questionAnswers);

        $createdquestion_answers = $createdquestion_answers->toArray();
        $this->assertArrayHasKey('id', $createdquestion_answers);
        $this->assertNotNull($createdquestion_answers['id'], 'Created question_answers must have id specified');
        $this->assertNotNull(question_answers::find($createdquestion_answers['id']), 'question_answers with given id must be in DB');
        $this->assertModelData($questionAnswers, $createdquestion_answers);
    }

    /**
     * @test read
     */
    public function test_read_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->create();

        $dbquestion_answers = $this->questionAnswersRepo->find($questionAnswers->id);

        $dbquestion_answers = $dbquestion_answers->toArray();
        $this->assertModelData($questionAnswers->toArray(), $dbquestion_answers);
    }

    /**
     * @test update
     */
    public function test_update_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->create();
        $fakequestion_answers = factory(question_answers::class)->make()->toArray();

        $updatedquestion_answers = $this->questionAnswersRepo->update($fakequestion_answers, $questionAnswers->id);

        $this->assertModelData($fakequestion_answers, $updatedquestion_answers->toArray());
        $dbquestion_answers = $this->questionAnswersRepo->find($questionAnswers->id);
        $this->assertModelData($fakequestion_answers, $dbquestion_answers->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_question_answers()
    {
        $questionAnswers = factory(question_answers::class)->create();

        $resp = $this->questionAnswersRepo->delete($questionAnswers->id);

        $this->assertTrue($resp);
        $this->assertNull(question_answers::find($questionAnswers->id), 'question_answers should not exist in DB');
    }
}
