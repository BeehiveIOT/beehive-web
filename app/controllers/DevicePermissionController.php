<?php

use Beehive\Repo\Device\DeviceRepo;
use Beehive\Repo\User\UserRepo;
use Beehive\Service\Validation\PermissionValidator;

class DevicePermissionController extends BaseController
{
    protected $deviceRepo;
    protected $userRepo;
    protected $permissionValidator;

    public function __construct(
        DeviceRepo $deviceRepo,
        UserRepo $userRepo,
        PermissionValidator $permissionValidator)
    {
        $this->deviceRepo = $deviceRepo;
        $this->userRepo = $userRepo;
        $this->permissionValidator = $permissionValidator;
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

    public function store($deviceId)
    {
        $data = Input::all();
        if ($this->permissionValidator->with($data)->passes()) {
            return Response::json($this->permissionValidator->erros(), 400);
        }

        if(!$user = $this->userRepo->getByUsername(Input::get('username', ''))) {
            return Response::json([
                'status' => 'User does not exist'
            ], 404);
        }

        if (!$this->deviceRepo->canEdit($deviceId, Auth::id())) {
            return Response::json([
                'status' => 'You are not an admin'
            ], 403);
        }

        if ($this->deviceRepo->isOwner($deviceId, $user->id)) {
            return Response::json([
                'status' => 'Cannot edit owner'
            ], 403);
        }

        $data['user_id'] = $user->id;
        $result = $this->deviceRepo->addAdmin($deviceId, $data);

        return Response::json($result, 200);
    }

    public function destroy($deviceId, $userId)
    {
        if (!$this->deviceRepo->canEdit($deviceId, Auth::id())) {
            return Response::json([
                'status' => 'You are not an admin'
            ], 403);
        }

        if ($this->deviceRepo->removeAdmin($deviceId, $userId)) {
            return Response::json([
                'status' => 'ok'
            ], 200);
        }
        return Response::json([
            'status' => 'Cannot delete permission'
        ], 400);
    }
}
