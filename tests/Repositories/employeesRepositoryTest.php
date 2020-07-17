<?php namespace Tests\Repositories;

use App\Models\employees;
use App\Repositories\employeesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class employeesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var employeesRepository
     */
    protected $employeesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->employeesRepo = \App::make(employeesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_employees()
    {
        $employees = factory(employees::class)->make()->toArray();

        $createdemployees = $this->employeesRepo->create($employees);

        $createdemployees = $createdemployees->toArray();
        $this->assertArrayHasKey('id', $createdemployees);
        $this->assertNotNull($createdemployees['id'], 'Created employees must have id specified');
        $this->assertNotNull(employees::find($createdemployees['id']), 'employees with given id must be in DB');
        $this->assertModelData($employees, $createdemployees);
    }

    /**
     * @test read
     */
    public function test_read_employees()
    {
        $employees = factory(employees::class)->create();

        $dbemployees = $this->employeesRepo->find($employees->id);

        $dbemployees = $dbemployees->toArray();
        $this->assertModelData($employees->toArray(), $dbemployees);
    }

    /**
     * @test update
     */
    public function test_update_employees()
    {
        $employees = factory(employees::class)->create();
        $fakeemployees = factory(employees::class)->make()->toArray();

        $updatedemployees = $this->employeesRepo->update($fakeemployees, $employees->id);

        $this->assertModelData($fakeemployees, $updatedemployees->toArray());
        $dbemployees = $this->employeesRepo->find($employees->id);
        $this->assertModelData($fakeemployees, $dbemployees->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_employees()
    {
        $employees = factory(employees::class)->create();

        $resp = $this->employeesRepo->delete($employees->id);

        $this->assertTrue($resp);
        $this->assertNull(employees::find($employees->id), 'employees should not exist in DB');
    }
}
