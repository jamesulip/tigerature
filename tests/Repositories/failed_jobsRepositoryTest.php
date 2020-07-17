<?php namespace Tests\Repositories;

use App\Models\failed_jobs;
use App\Repositories\failed_jobsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class failed_jobsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var failed_jobsRepository
     */
    protected $failedJobsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->failedJobsRepo = \App::make(failed_jobsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->make()->toArray();

        $createdfailed_jobs = $this->failedJobsRepo->create($failedJobs);

        $createdfailed_jobs = $createdfailed_jobs->toArray();
        $this->assertArrayHasKey('id', $createdfailed_jobs);
        $this->assertNotNull($createdfailed_jobs['id'], 'Created failed_jobs must have id specified');
        $this->assertNotNull(failed_jobs::find($createdfailed_jobs['id']), 'failed_jobs with given id must be in DB');
        $this->assertModelData($failedJobs, $createdfailed_jobs);
    }

    /**
     * @test read
     */
    public function test_read_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->create();

        $dbfailed_jobs = $this->failedJobsRepo->find($failedJobs->id);

        $dbfailed_jobs = $dbfailed_jobs->toArray();
        $this->assertModelData($failedJobs->toArray(), $dbfailed_jobs);
    }

    /**
     * @test update
     */
    public function test_update_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->create();
        $fakefailed_jobs = factory(failed_jobs::class)->make()->toArray();

        $updatedfailed_jobs = $this->failedJobsRepo->update($fakefailed_jobs, $failedJobs->id);

        $this->assertModelData($fakefailed_jobs, $updatedfailed_jobs->toArray());
        $dbfailed_jobs = $this->failedJobsRepo->find($failedJobs->id);
        $this->assertModelData($fakefailed_jobs, $dbfailed_jobs->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->create();

        $resp = $this->failedJobsRepo->delete($failedJobs->id);

        $this->assertTrue($resp);
        $this->assertNull(failed_jobs::find($failedJobs->id), 'failed_jobs should not exist in DB');
    }
}
