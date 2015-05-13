<?php

use Beehive\Repo\Device\DeviceRepo;
use Beehive\Service\Validation\DeviceValidator;
use Beehive\Repo\Command\CommandRepo;
use Beehive\Repo\DataStream\DataStreamRepo;

class DeviceController extends BaseController {
	protected $deviceRepo;
	protected $commandRepo;
	protected $validator;
	protected $dataStreamRepo;

	public function __construct(
		DeviceRepo $deviceRepo,
		DeviceValidator $validator,
		CommandRepo $commandRepo,
		DataStreamRepo $dataStreamRepo)
	{
		$this->deviceRepo = $deviceRepo;
		$this->validator = $validator;
		$this->commandRepo = $commandRepo;
		$this->dataStreamRepo = $dataStreamRepo;
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

	public function getByTemplate($templateId) {
		$columns = ['devices.id', 'name', 'description'];
		$extra = ['userId' => Auth::id()];
		$devices = $this->deviceRepo->getByTemplate($templateId, $columns, $extra);

		return Response::json($devices, 200);
	}

	public function show($id)
	{
		$columns = ['devices.id', 'name', 'description',
			'template_id', 'serial_number',
			'device_secret', 'pub_key',
			'sub_key', 'is_public'
		];
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

	public function getCommands($id)
	{
		if (!$device = $this->deviceRepo->getByUser($id, Auth::id())) {
			return Response::json(['status' => ['Device not found']], 404);
		}
		$commands = $this->commandRepo->getAllByTemplate($device->template_id);

		return Response::json($commands, 200);
	}

	public function getDataStreams($id)
	{
		if (!$device = $this->deviceRepo->getByUser($id, Auth::id())) {
			return Response::json(['status' => ['Device not found']], 404);
		}

		$dataStreams = $this->dataStreamRepo->getByTemplate($device->template_id);

		return Response::json($dataStreams, 200);
	}

	public function executeCommand($id, $commandId)
	{
		if (!$device = $this->deviceRepo->getByUser($id, Auth::id())) {
			return Response::json(['status' => ['Device not found']], 404);
		}
		// $templateId = $device->template_id;
		// $extra = ['user_id' => Auth::id()];
		// if (!$command = $this->commandRepo->getByTemplate($commandId, $templateId, $extra)) {
		// 	return Response::json(['status' => ['Command not found']], 404);
		// }
		if (!$command = $this->commandRepo->get($commandId)) {
			return Response::json(['status' => ['Command not found']], 404);
		}

		$topic = $device->sub_key . '/command';
		$arguments = Input::get('arguments', []);
		$timestamp = $this->commandRepo->executeCommand($commandId, $topic, $arguments);

		return Response::json([
			'command_id' => $commandId,
			'command_name' => $command->name,
			'timestamp' => $timestamp
		], 200);
	}
}
