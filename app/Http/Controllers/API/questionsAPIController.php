<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatequestionsAPIRequest;
use App\Http\Requests\API\UpdatequestionsAPIRequest;
use App\Models\questions;
use App\Repositories\questionsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class questionsController
 * @package App\Http\Controllers\API
 */

class questionsAPIController extends AppBaseController
{
    /** @var  questionsRepository */
    private $questionsRepository;

    public function __construct(questionsRepository $questionsRepo)
    {
        $this->questionsRepository = $questionsRepo;
    }

    /**
     * Display a listing of the questions.
     * GET|HEAD /questions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questions = $this->questionsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($questions->toArray(), 'Questions retrieved successfully');
    }

    /**
     * Store a newly created questions in storage.
     * POST /questions
     *
     * @param CreatequestionsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatequestionsAPIRequest $request)
    {
        $input = $request->all();

        $questions = $this->questionsRepository->create($input);

        return $this->sendResponse($questions->toArray(), 'Questions saved successfully');
    }

    /**
     * Display the specified questions.
     * GET|HEAD /questions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var questions $questions */
        $questions = $this->questionsRepository->find($id);

        if (empty($questions)) {
            return $this->sendError('Questions not found');
        }

        return $this->sendResponse($questions->toArray(), 'Questions retrieved successfully');
    }

    /**
     * Update the specified questions in storage.
     * PUT/PATCH /questions/{id}
     *
     * @param int $id
     * @param UpdatequestionsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatequestionsAPIRequest $request)
    {
        $input = $request->all();

        /** @var questions $questions */
        $questions = $this->questionsRepository->find($id);

        if (empty($questions)) {
            return $this->sendError('Questions not found');
        }

        $questions = $this->questionsRepository->update($input, $id);

        return $this->sendResponse($questions->toArray(), 'questions updated successfully');
    }

    /**
     * Remove the specified questions from storage.
     * DELETE /questions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var questions $questions */
        $questions = $this->questionsRepository->find($id);

        if (empty($questions)) {
            return $this->sendError('Questions not found');
        }

        $questions->delete();

        return $this->sendSuccess('Questions deleted successfully');
    }
}
