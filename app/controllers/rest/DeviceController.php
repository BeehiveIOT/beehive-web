<?php
namespace Controllers\Rest;

use Beehive\Repo\Device\DeviceRepo;
use Beehive\Service\Validation\DeviceValidator;
use Response, Input;

class DeviceController extends RestController
{
    protected $deviceRepo;
    protected $validator;

    public function __construct(DeviceRepo $deviceRepo, DeviceValidator $deviceValidator)
    {
        $this->deviceRepo = $deviceRepo;
        $this->validator = $deviceValidator;
    }

    public function index()
    {
        $columns = ['devices.id', 'name', 'description',
            'template_id', 'serial_number',
            'device_secret', 'pub_key',
            'sub_key', 'is_public'
        ];
        $user = parent::getAuthUser();
        $devices = $this->deviceRepo->getAllByUser($user->id, $columns);

        return Response::json($devices, 200);
    }

    public function store()
    {
        $data = Input::all();
        if (!$this->validator->with($data)->passes()) {
            return Response::json($this->validator->errors(), 400);
        }

        try {
            $extra = ['user_id'=>parent::id()];
            $device = $this->deviceRepo->create($data, $extra);

            return Response::json(['id'=>$device->id], 200);
        }
        catch(BeehiveException $e) {
            return Response::json(['status'=>[$e->getMessage()]], $e->getCode());
        }
    }

    public function show($id)
    {
        $columns = ['devices.id', 'name', 'description',
            'template_id', 'serial_number',
            'device_secret', 'pub_key',
            'sub_key', 'is_public'
        ];
        $user = parent::getAuthUser();
        if (!$device = $this->deviceRepo->getByUser($id, $user->id, $columns)) {
            return Response::json(['status'=>['Device not found']], 404);
        }

        return Response::json($device, 200);
    }

    public function update($id)
    {
        $data = Input::only(['name','description', 'is_public']);
        if (!$this->validator->with($data)->passes()) {
            return Response::json($this->validator->errors(), 400);
        }

        try {
            $extra = ['user_id'=>parent::id()];
            $device = $this->deviceRepo->update($id, $data, $extra);

            return Response::json($device, 200);
        }
        catch(BeehiveException $e) {
            return Response::json(['status'=>[$e->getMessage()]], $e->getCode());
        }
    }

    public function destroy($id)
    {
        return Response::json([
            'status' => 'Not implemented'
        ], 501);
    }
}
