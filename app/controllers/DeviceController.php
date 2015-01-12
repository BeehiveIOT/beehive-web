<?php

use Beehive\Repo\Device\DeviceRepo;
use Beehive\Service\Validation\DeviceValidator;

class DeviceController extends BaseController {
	protected $deviceRepo;
	protected $validator;

	public function __construct(DeviceRepo $deviceRepo, DeviceValidator $validator){
		$this->deviceRepo = $deviceRepo;
		$this->validator = $validator;
	}

	public function page() {
		return View::make('device.index');
	}

	/**
	 * Get a list of devices
	 *
	 * @return Response
	 */
	public function index() {
		$columns = ['devices.id', 'name', 'description', 'picture_url'];
		$devices = $this->deviceRepo->getByUser(Auth::id(), $columns);

		return Response::json($devices, 200);
	}

	/**
	 * Store a device
	 *
	 * @return Response
	 */
	public function store()
	{
		if ($this->validator->with(Input::all())->passes()) {
			try {
				$device = $this->deviceRepo->createFor(Auth::id(), Input::all());

				return Response::json(['id'=>$device->id], 200);
			}
			catch(BeehiveException $e) {
				return Response::json(['status'=>'There was a problemo jefe'], 500);
			}
		} else {
			return Response::json($this->validator->errors(), 400);
		}
	}


	/**
	 * Display device
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$device = Auth::user()->devices()
			->where('device_id', '=', $id)
			->firstOrFail([
				'device_id as id', 'name', 'description', 'template_id',
				'uuid as product_id', 'device_secret', 'is_public'
			]);

		$device->commands = [];
		$template = $device->template()->get()->first();
		if ($template != null) {
			$commands = $template->commands()->get();
			$device->commands = $commands;
		}

		if ($device) {
			return Response::json($device, 200);
		} else {
			return Response::json(['message'=>'Not found'], 404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = ['name'=>'required|min:3'];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json($validator->messages(), 400);
		}

		$device = Auth::user()->devices()
			->where('device_id','=',$id)->firstOrFail();
		$device->name = Input::get('name');
		$device->description = Input::get('description');
		$device->is_public = Input::get('is_public');
		$device->save();

		return Response::json([
			'id'=>$device->id
		], 200);
	}

	/**
	 * Remove a device
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return Response::json([
			'status' => 'Not implemented'
		], 400);
	}
}
