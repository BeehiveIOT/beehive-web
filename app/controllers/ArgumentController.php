<?php

class ArgumentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::make('Ops', 404);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return Response::make('Ops', 404);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($commandId)
	{
		$command = Auth::user()->commands()
			->where('commands.id', '=', $commandId)->firstOrFail();

		$validator = Validator::make(Input::all(), [
			'name' => 'required|min:3',
			'type' => 'required|in:number,string',
		]);

		if ($validator->fails()) {
			return Response::json(['message'=>'Invalid data'], 400);
		}

		$argument = new Argument();
		$argument->name = Input::get('name');
		$argument->type = Input::get('type');
		$argument->default = Input::get('default');
		$argument->maximum = Input::get('max');
		$argument->minimum = Input::get('min');
		$argument->command_id = $commandId;
		$argument->save();

		return Response::json($argument, 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($commandId, $argumentId)
	{
		$command = Auth::user()->commands()
			->where('commands.id','=',$commandId)->get()->first();

		if (!$command) {
			return Response::json(['message'=>'Not found'], 404);
		}

		$argument = $command->arguments()
			->where('id','=',$argumentId)->get()->first();

		if (!$argument) {
			return Response::json(['message'=>'Not found'], 404);
		}

		return Response::json($argument, 200);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return Response::make('Ops', 404);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return Response::make('Ops', 404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $commandId
	 * @param  int  $argumentId
	 * @return Response
	 */
	public function destroy($commandId, $argumentId)
	{
		$command = Auth::user()->commands()
			->where('commands.id','=',$commandId)->get()->first();

		if (!$command) {
			return Response::json(['message'=>'Not found'], 404);
		}

		$argument = $command->arguments()
			->where('id','=',$argumentId)->get()->first();

		if (!$argument) {
			return Response::json(['message'=>'Not found'], 404);
		}

		$argument->delete();

		return Response::make("OK", 200);
	}

}
