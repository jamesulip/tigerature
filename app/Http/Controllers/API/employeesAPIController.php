<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateemployeesAPIRequest;
use App\Http\Requests\API\UpdateemployeesAPIRequest;
use App\Models\employees;
use App\Repositories\employeesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class employeesController
 * @package App\Http\Controllers\API
 */

class employeesAPIController extends AppBaseController
{
    /** @var  employeesRepository */
    private $employeesRepository;

    public function __construct(employeesRepository $employeesRepo)
    {
        $this->employeesRepository = $employeesRepo;
    }

    /**
     * Display a listing of the employees.
     * GET|HEAD /employees
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $employees = $this->employeesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($employees->toArray(), 'Employees retrieved successfully');
    }

    /**
     * Store a newly created employees in storage.
     * POST /employees
     *
     * @param CreateemployeesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateemployeesAPIRequest $request)
    {
        $input = $request->all();

        $employees = $this->employeesRepository->create($input);

        return $this->sendResponse($employees->toArray(), 'Employees saved successfully');
    }

    /**
     * Display the specified employees.
     * GET|HEAD /employees/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var employees $employees */
        $employees = $this->employeesRepository->find($id);

        if (empty($employees)) {
            return $this->sendError('Employees not found');
        }

        return $this->sendResponse($employees->toArray(), 'Employees retrieved successfully');
    }

    /**
     * Update the specified employees in storage.
     * PUT/PATCH /employees/{id}
     *
     * @param int $id
     * @param UpdateemployeesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateemployeesAPIRequest $request)
    {
        $input = $request->all();

        /** @var employees $employees */
        $employees = $this->employeesRepository->find($id);

        if (empty($employees)) {
            return $this->sendError('Employees not found');
        }

        $employees = $this->employeesRepository->update($input, $id);

        return $this->sendResponse($employees->toArray(), 'employees updated successfully');
    }

    /**
     * Remove the specified employees from storage.
     * DELETE /employees/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var employees $employees */
        $employees = $this->employeesRepository->find($id);

        if (empty($employees)) {
            return $this->sendError('Employees not found');
        }

        $employees->delete();

        return $this->sendSuccess('Employees deleted successfully');
    }
}
