<?php namespace Tests\Repositories;

use App\Models\log;
use App\Repositories\logRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class logRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var logRepository
     */
    protected $logRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->logRepo = \App::make(logRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_log()
    {
        $log = factory(log::class)->make()->toArray();

        $createdlog = $this->logRepo->create($log);

        $createdlog = $createdlog->toArray();
        $this->assertArrayHasKey('id', $createdlog);
        $this->assertNotNull($createdlog['id'], 'Created log must have id specified');
        $this->assertNotNull(log::find($createdlog['id']), 'log with given id must be in DB');
        $this->assertModelData($log, $createdlog);
    }

    /**
     * @test read
     */
    public function test_read_log()
    {
        $log = factory(log::class)->create();

        $dblog = $this->logRepo->find($log->id);

        $dblog = $dblog->toArray();
        $this->assertModelData($log->toArray(), $dblog);
    }

    /**
     * @test update
     */
    public function test_update_log()
    {
        $log = factory(log::class)->create();
        $fakelog = factory(log::class)->make()->toArray();

        $updatedlog = $this->logRepo->update($fakelog, $log->id);

        $this->assertModelData($fakelog, $updatedlog->toArray());
        $dblog = $this->logRepo->find($log->id);
        $this->assertModelData($fakelog, $dblog->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_log()
    {
        $log = factory(log::class)->create();

        $resp = $this->logRepo->delete($log->id);

        $this->assertTrue($resp);
        $this->assertNull(log::find($log->id), 'log should not exist in DB');
    }
}
