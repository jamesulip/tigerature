<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedeviceAPIRequest;
use App\Http\Requests\API\UpdatedeviceAPIRequest;
use App\Models\device;
use App\Repositories\deviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class deviceController
 * @package App\Http\Controllers\API
 */

class deviceAPIController extends AppBaseController
{
    /** @var  deviceRepository */
    private $deviceRepository;

    public function __construct(deviceRepository $deviceRepo)
    {
        $this->deviceRepository = $deviceRepo;
    }

    /**
     * Display a listing of the device.
     * GET|HEAD /devices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $devices = $this->deviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($devices->toArray(), 'Devices retrieved successfully');
    }

    /**
     * Store a newly created device in storage.
     * POST /devices
     *
     * @param CreatedeviceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedeviceAPIRequest $request)
    {
        $input = $request->all();

        $device = $this->deviceRepository->create($input);

        return $this->sendResponse($device->toArray(), 'Device saved successfully');
    }

    /**
     * Display the specified device.
     * GET|HEAD /devices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var device $device */
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            return $this->sendError('Device not found');
        }

        return $this->sendResponse($device->toArray(), 'Device retrieved successfully');
    }

    /**
     * Update the specified device in storage.
     * PUT/PATCH /devices/{id}
     *
     * @param int $id
     * @param UpdatedeviceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedeviceAPIRequest $request)
    {
        $input = $request->all();

        /** @var device $device */
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            return $this->sendError('Device not found');
        }

        $device = $this->deviceRepository->update($input, $id);

        return $this->sendResponse($device->toArray(), 'device updated successfully');
    }

    /**
     * Remove the specified device from storage.
     * DELETE /devices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var device $device */
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            return $this->sendError('Device not found');
        }

        $device->delete();

        return $this->sendSuccess('Device deleted successfully');
    }
}
