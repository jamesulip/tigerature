<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\failed_jobs;

class failed_jobsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/failed_jobs', $failedJobs
        );

        $this->assertApiResponse($failedJobs);
    }

    /**
     * @test
     */
    public function test_read_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/failed_jobs/'.$failedJobs->id
        );

        $this->assertApiResponse($failedJobs->toArray());
    }

    /**
     * @test
     */
    public function test_update_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->create();
        $editedfailed_jobs = factory(failed_jobs::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/failed_jobs/'.$failedJobs->id,
            $editedfailed_jobs
        );

        $this->assertApiResponse($editedfailed_jobs);
    }

    /**
     * @test
     */
    public function test_delete_failed_jobs()
    {
        $failedJobs = factory(failed_jobs::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/failed_jobs/'.$failedJobs->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/failed_jobs/'.$failedJobs->id
        );

        $this->response->assertStatus(404);
    }
}
