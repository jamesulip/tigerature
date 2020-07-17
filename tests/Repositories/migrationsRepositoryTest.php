<?php namespace Tests\Repositories;

use App\Models\migrations;
use App\Repositories\migrationsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class migrationsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var migrationsRepository
     */
    protected $migrationsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->migrationsRepo = \App::make(migrationsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_migrations()
    {
        $migrations = factory(migrations::class)->make()->toArray();

        $createdmigrations = $this->migrationsRepo->create($migrations);

        $createdmigrations = $createdmigrations->toArray();
        $this->assertArrayHasKey('id', $createdmigrations);
        $this->assertNotNull($createdmigrations['id'], 'Created migrations must have id specified');
        $this->assertNotNull(migrations::find($createdmigrations['id']), 'migrations with given id must be in DB');
        $this->assertModelData($migrations, $createdmigrations);
    }

    /**
     * @test read
     */
    public function test_read_migrations()
    {
        $migrations = factory(migrations::class)->create();

        $dbmigrations = $this->migrationsRepo->find($migrations->id);

        $dbmigrations = $dbmigrations->toArray();
        $this->assertModelData($migrations->toArray(), $dbmigrations);
    }

    /**
     * @test update
     */
    public function test_update_migrations()
    {
        $migrations = factory(migrations::class)->create();
        $fakemigrations = factory(migrations::class)->make()->toArray();

        $updatedmigrations = $this->migrationsRepo->update($fakemigrations, $migrations->id);

        $this->assertModelData($fakemigrations, $updatedmigrations->toArray());
        $dbmigrations = $this->migrationsRepo->find($migrations->id);
        $this->assertModelData($fakemigrations, $dbmigrations->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_migrations()
    {
        $migrations = factory(migrations::class)->create();

        $resp = $this->migrationsRepo->delete($migrations->id);

        $this->assertTrue($resp);
        $this->assertNull(migrations::find($migrations->id), 'migrations should not exist in DB');
    }
}
