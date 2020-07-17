<?php namespace Tests\Repositories;

use App\Models\password_resets;
use App\Repositories\password_resetsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class password_resetsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var password_resetsRepository
     */
    protected $passwordResetsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->passwordResetsRepo = \App::make(password_resetsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_password_resets()
    {
        $passwordResets = factory(password_resets::class)->make()->toArray();

        $createdpassword_resets = $this->passwordResetsRepo->create($passwordResets);

        $createdpassword_resets = $createdpassword_resets->toArray();
        $this->assertArrayHasKey('id', $createdpassword_resets);
        $this->assertNotNull($createdpassword_resets['id'], 'Created password_resets must have id specified');
        $this->assertNotNull(password_resets::find($createdpassword_resets['id']), 'password_resets with given id must be in DB');
        $this->assertModelData($passwordResets, $createdpassword_resets);
    }

    /**
     * @test read
     */
    public function test_read_password_resets()
    {
        $passwordResets = factory(password_resets::class)->create();

        $dbpassword_resets = $this->passwordResetsRepo->find($passwordResets->id);

        $dbpassword_resets = $dbpassword_resets->toArray();
        $this->assertModelData($passwordResets->toArray(), $dbpassword_resets);
    }

    /**
     * @test update
     */
    public function test_update_password_resets()
    {
        $passwordResets = factory(password_resets::class)->create();
        $fakepassword_resets = factory(password_resets::class)->make()->toArray();

        $updatedpassword_resets = $this->passwordResetsRepo->update($fakepassword_resets, $passwordResets->id);

        $this->assertModelData($fakepassword_resets, $updatedpassword_resets->toArray());
        $dbpassword_resets = $this->passwordResetsRepo->find($passwordResets->id);
        $this->assertModelData($fakepassword_resets, $dbpassword_resets->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_password_resets()
    {
        $passwordResets = factory(password_resets::class)->create();

        $resp = $this->passwordResetsRepo->delete($passwordResets->id);

        $this->assertTrue($resp);
        $this->assertNull(password_resets::find($passwordResets->id), 'password_resets should not exist in DB');
    }
}
