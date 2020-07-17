<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createfailed_jobsAPIRequest;
use App\Http\Requests\API\Updatefailed_jobsAPIRequest;
use App\Models\failed_jobs;
use App\Repositories\failed_jobsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class failed_jobsController
 * @package App\Http\Controllers\API
 */

class failed_jobsAPIController extends AppBaseController
{
    /** @var  failed_jobsRepository */
    private $failedJobsRepository;

    public function __construct(failed_jobsRepository $failedJobsRepo)
    {
        $this->failedJobsRepository = $failedJobsRepo;
    }

    /**
     * Display a listing of the failed_jobs.
     * GET|HEAD /failedJobs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $failedJobs = $this->failedJobsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($failedJobs->toArray(), 'Failed Jobs retrieved successfully');
    }

    /**
     * Store a newly created failed_jobs in storage.
     * POST /failedJobs
     *
     * @param Createfailed_jobsAPIRequest $request
     *
     * @return Response
     */
    public function store(Createfailed_jobsAPIRequest $request)
    {
        $input = $request->all();

        $failedJobs = $this->failedJobsRepository->create($input);

        return $this->sendResponse($failedJobs->toArray(), 'Failed Jobs saved successfully');
    }

    /**
     * Display the specified failed_jobs.
     * GET|HEAD /failedJobs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var failed_jobs $failedJobs */
        $failedJobs = $this->failedJobsRepository->find($id);

        if (empty($failedJobs)) {
            return $this->sendError('Failed Jobs not found');
        }

        return $this->sendResponse($failedJobs->toArray(), 'Failed Jobs retrieved successfully');
    }

    /**
     * Update the specified failed_jobs in storage.
     * PUT/PATCH /failedJobs/{id}
     *
     * @param int $id
     * @param Updatefailed_jobsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatefailed_jobsAPIRequest $request)
    {
        $input = $request->all();

        /** @var failed_jobs $failedJobs */
        $failedJobs = $this->failedJobsRepository->find($id);

        if (empty($failedJobs)) {
            return $this->sendError('Failed Jobs not found');
        }

        $failedJobs = $this->failedJobsRepository->update($input, $id);

        return $this->sendResponse($failedJobs->toArray(), 'failed_jobs updated successfully');
    }

    /**
     * Remove the specified failed_jobs from storage.
     * DELETE /failedJobs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var failed_jobs $failedJobs */
        $failedJobs = $this->failedJobsRepository->find($id);

        if (empty($failedJobs)) {
            return $this->sendError('Failed Jobs not found');
        }

        $failedJobs->delete();

        return $this->sendSuccess('Failed Jobs deleted successfully');
    }
}
