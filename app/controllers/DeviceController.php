<?php

use Beehive\Repo\Device\DeviceRepo;
use Beehive\Service\Validation\DeviceValidator;
use Beehive\Repo\Command\CommandRepo;

class DeviceController extends BaseController {
	protected $deviceRepo;
	protected $commandRepo;
	protected $validator;

	public function __construct(
		DeviceRepo $deviceRepo,
		DeviceValidator $validator,
		CommandRepo $commandRepo)
	{
		$this->deviceRepo = $deviceRepo;
		$this->validator = $validator;
		$this->commandRepo = $commandRepo;
	}

	public function page()
	{
		return View::make('device.index');
	}

	public function device($id)
	{
		return View::make('device.panel')
			->with('deviceId', $id);
	}

	public function index()
	{
		$columns = ['devices.id', 'name', 'description'];
		$devices = $this->deviceRepo->getAllByUser(Auth::id(), $columns);

		return Response::json($devices, 200);
	}

	public function store()
	{
		$data = Input::all();
		if (!$this->validator->with($data)->passes()) {
			return Response::json($this->validator->errors(), 400);
		}

		try {
			$extra = ['user_id'=>Auth::id()];
			$device = $this->deviceRepo->create($data, $extra);

			return Response::json(['id'=>$device->id], 200);
		}
		catch(BeehiveException $e) {
			return Response::json(['status'=>[$e->getMessage()]], $e->getCode());
		}
	}

	public function show($id)
	{
		$columns = ['devices.id', 'name', 'description', 'template_id', 'serial_number', 'device_secret', 'pub_key', 'sub_key', 'is_public'];
		if (!$device = $this->deviceRepo->getByUser($id, Auth::id(), $columns)) {
			return Response::json(['status'=>['Device not found']], 404);
		}

		$commands = $this->commandRepo->getAllByTemplate($device->template_id);
		$device->commands = $commands;

		return Response::json($device, 200);
	}

	public function update($id)
	{
		$data = Input::only(['name','description', 'is_public']);
		if (!$this->validator->with($data)->passes()) {
			return Response::json($this->validator->errors(), 400);
		}

		try {
			$extra = ['user_id'=>Auth::id()];
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
		], 400);
	}

	public function getCommands($id) {
		// TODO: return commands from device
		return Response::json([], 200);
	}
}
