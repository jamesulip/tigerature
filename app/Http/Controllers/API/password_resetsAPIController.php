<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createpassword_resetsAPIRequest;
use App\Http\Requests\API\Updatepassword_resetsAPIRequest;
use App\Models\password_resets;
use App\Repositories\password_resetsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class password_resetsController
 * @package App\Http\Controllers\API
 */

class password_resetsAPIController extends AppBaseController
{
    /** @var  password_resetsRepository */
    private $passwordResetsRepository;

    public function __construct(password_resetsRepository $passwordResetsRepo)
    {
        $this->passwordResetsRepository = $passwordResetsRepo;
    }

    /**
     * Display a listing of the password_resets.
     * GET|HEAD /passwordResets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $passwordResets = $this->passwordResetsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($passwordResets->toArray(), 'Password Resets retrieved successfully');
    }

    /**
     * Store a newly created password_resets in storage.
     * POST /passwordResets
     *
     * @param Createpassword_resetsAPIRequest $request
     *
     * @return Response
     */
    public function store(Createpassword_resetsAPIRequest $request)
    {
        $input = $request->all();

        $passwordResets = $this->passwordResetsRepository->create($input);

        return $this->sendResponse($passwordResets->toArray(), 'Password Resets saved successfully');
    }

    /**
     * Display the specified password_resets.
     * GET|HEAD /passwordResets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var password_resets $passwordResets */
        $passwordResets = $this->passwordResetsRepository->find($id);

        if (empty($passwordResets)) {
            return $this->sendError('Password Resets not found');
        }

        return $this->sendResponse($passwordResets->toArray(), 'Password Resets retrieved successfully');
    }

    /**
     * Update the specified password_resets in storage.
     * PUT/PATCH /passwordResets/{id}
     *
     * @param int $id
     * @param Updatepassword_resetsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatepassword_resetsAPIRequest $request)
    {
        $input = $request->all();

        /** @var password_resets $passwordResets */
        $passwordResets = $this->passwordResetsRepository->find($id);

        if (empty($passwordResets)) {
            return $this->sendError('Password Resets not found');
        }

        $passwordResets = $this->passwordResetsRepository->update($input, $id);

        return $this->sendResponse($passwordResets->toArray(), 'password_resets updated successfully');
    }

    /**
     * Remove the specified password_resets from storage.
     * DELETE /passwordResets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var password_resets $passwordResets */
        $passwordResets = $this->passwordResetsRepository->find($id);

        if (empty($passwordResets)) {
            return $this->sendError('Password Resets not found');
        }

        $passwordResets->delete();

        return $this->sendSuccess('Password Resets deleted successfully');
    }
}
