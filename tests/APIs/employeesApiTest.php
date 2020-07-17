<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\employees;

class employeesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_employees()
    {
        $employees = factory(employees::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/employees', $employees
        );

        $this->assertApiResponse($employees);
    }

    /**
     * @test
     */
    public function test_read_employees()
    {
        $employees = factory(employees::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/employees/'.$employees->id
        );

        $this->assertApiResponse($employees->toArray());
    }

    /**
     * @test
     */
    public function test_update_employees()
    {
        $employees = factory(employees::class)->create();
        $editedemployees = factory(employees::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/employees/'.$employees->id,
            $editedemployees
        );

        $this->assertApiResponse($editedemployees);
    }

    /**
     * @test
     */
    public function test_delete_employees()
    {
        $employees = factory(employees::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/employees/'.$employees->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/employees/'.$employees->id
        );

        $this->response->assertStatus(404);
    }
}
