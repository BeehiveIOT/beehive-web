<?php

use Beehive\Repo\Device\DeviceRepo;

class DevicePermissionController extends BaseController
{
    protected $deviceRepo;

    public function __construct(DeviceRepo $deviceRepo)
    {
        $this->deviceRepo = $deviceRepo;
    }

    public function page($all='')
    {
        return View::make('permission.index');
    }

    public function index($deviceId)
    {
        $userId = Auth::id();
        $extra = ['userId' => $userId];
        if ($this->deviceRepo->isAdmin($deviceId, $userId)) {
            $admins = $this->deviceRepo->getPermissions($deviceId, $extra);

            return Response::json($admins, 200);
        }
        return Response::json([
            'status' => 'Not an admin'
        ], 403);
    }
}
