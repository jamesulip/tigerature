<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createquestion_answersAPIRequest;
use App\Http\Requests\API\Updatequestion_answersAPIRequest;
use App\Models\question_answers;
use App\Repositories\question_answersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class question_answersController
 * @package App\Http\Controllers\API
 */

class question_answersAPIController extends AppBaseController
{
    /** @var  question_answersRepository */
    private $questionAnswersRepository;

    public function __construct(question_answersRepository $questionAnswersRepo)
    {
        $this->questionAnswersRepository = $questionAnswersRepo;
    }

    /**
     * Display a listing of the question_answers.
     * GET|HEAD /questionAnswers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questionAnswers = $this->questionAnswersRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($questionAnswers->toArray(), 'Question Answers retrieved successfully');
    }

    /**
     * Store a newly created question_answers in storage.
     * POST /questionAnswers
     *
     * @param Createquestion_answersAPIRequest $request
     *
     * @return Response
     */
    public function store(Createquestion_answersAPIRequest $request)
    {
        $input = $request->all();

        $questionAnswers = $this->questionAnswersRepository->create($input);

        return $this->sendResponse($questionAnswers->toArray(), 'Question Answers saved successfully');
    }

    /**
     * Display the specified question_answers.
     * GET|HEAD /questionAnswers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var question_answers $questionAnswers */
        $questionAnswers = $this->questionAnswersRepository->find($id);

        if (empty($questionAnswers)) {
            return $this->sendError('Question Answers not found');
        }

        return $this->sendResponse($questionAnswers->toArray(), 'Question Answers retrieved successfully');
    }

    /**
     * Update the specified question_answers in storage.
     * PUT/PATCH /questionAnswers/{id}
     *
     * @param int $id
     * @param Updatequestion_answersAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatequestion_answersAPIRequest $request)
    {
        $input = $request->all();

        /** @var question_answers $questionAnswers */
        $questionAnswers = $this->questionAnswersRepository->find($id);

        if (empty($questionAnswers)) {
            return $this->sendError('Question Answers not found');
        }

        $questionAnswers = $this->questionAnswersRepository->update($input, $id);

        return $this->sendResponse($questionAnswers->toArray(), 'question_answers updated successfully');
    }

    /**
     * Remove the specified question_answers from storage.
     * DELETE /questionAnswers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var question_answers $questionAnswers */
        $questionAnswers = $this->questionAnswersRepository->find($id);

        if (empty($questionAnswers)) {
            return $this->sendError('Question Answers not found');
        }

        $questionAnswers->delete();

        return $this->sendSuccess('Question Answers deleted successfully');
    }
}
