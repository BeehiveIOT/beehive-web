<?php

class DeviceController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		return View::make('device.index');
	}

	public function items() {
		$devices = Auth::user()->devices()
			->get(['devices.id', 'name', 'description', 'picture_url']);

		return Response::json($devices, 200);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'name'=>'required|min:3'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json($validator->messages(), 400);
		}

		if (Input::get('template')) {
			$template = Auth::user()->templates()
				->where('id', '=', Input::get('template'))->get()->first();

			if ($template == null) {
				return Response::json(['template'=>'Invalid template'], 400);
			}
		}


		$device = new Device();
		$device->name = Input::get('name');
		$device->uuid = GUID::generate();
		$device->device_secret = GUID::generate();
		$device->description = Input::get('description');
		$device->is_public = Input::get('isPublic')?true : false;
		$device->template_id = Input::get('template_id');
		$device->save();
		$device->administrators()->attach(Auth::user()->id);

		return Response::json(['id'=>$device->id], 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$device = Auth::user()->devices()
			->where('device_id', '=', $id)
			->firstOrFail([
				'device_id as id', 'name', 'description', 'template_id as template',
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
