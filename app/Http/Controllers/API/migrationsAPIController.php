<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatemigrationsAPIRequest;
use App\Http\Requests\API\UpdatemigrationsAPIRequest;
use App\Models\migrations;
use App\Repositories\migrationsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class migrationsController
 * @package App\Http\Controllers\API
 */

class migrationsAPIController extends AppBaseController
{
    /** @var  migrationsRepository */
    private $migrationsRepository;

    public function __construct(migrationsRepository $migrationsRepo)
    {
        $this->migrationsRepository = $migrationsRepo;
    }

    /**
     * Display a listing of the migrations.
     * GET|HEAD /migrations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $migrations = $this->migrationsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($migrations->toArray(), 'Migrations retrieved successfully');
    }

    /**
     * Store a newly created migrations in storage.
     * POST /migrations
     *
     * @param CreatemigrationsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatemigrationsAPIRequest $request)
    {
        $input = $request->all();

        $migrations = $this->migrationsRepository->create($input);

        return $this->sendResponse($migrations->toArray(), 'Migrations saved successfully');
    }

    /**
     * Display the specified migrations.
     * GET|HEAD /migrations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var migrations $migrations */
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            return $this->sendError('Migrations not found');
        }

        return $this->sendResponse($migrations->toArray(), 'Migrations retrieved successfully');
    }

    /**
     * Update the specified migrations in storage.
     * PUT/PATCH /migrations/{id}
     *
     * @param int $id
     * @param UpdatemigrationsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemigrationsAPIRequest $request)
    {
        $input = $request->all();

        /** @var migrations $migrations */
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            return $this->sendError('Migrations not found');
        }

        $migrations = $this->migrationsRepository->update($input, $id);

        return $this->sendResponse($migrations->toArray(), 'migrations updated successfully');
    }

    /**
     * Remove the specified migrations from storage.
     * DELETE /migrations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var migrations $migrations */
        $migrations = $this->migrationsRepository->find($id);

        if (empty($migrations)) {
            return $this->sendError('Migrations not found');
        }

        $migrations->delete();

        return $this->sendSuccess('Migrations deleted successfully');
    }
}
