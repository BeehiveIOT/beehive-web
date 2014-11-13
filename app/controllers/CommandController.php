<?php

class CommandController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($templateId)
	{
		$commands = Auth::user()->commands()
			->where('template_id', '=', $templateId)->get();

		return $commands;
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
	public function store($templateId)
	{
		$data = Input::all();
		$data['template_id'] = $templateId;
		$commandRules = [
			'name' => 'required|min:3',
			'short_cmd' => 'required',
			'cmd_type' => 'required|in:int,string',
			'template_id' => 'exists:templates,id'
		];

		// Init transaction
		$command = new Command();
		DB::transaction(function() use($command, $templateId) {
			$command->name = Input::get('name');
			$command->short_cmd = Input::get('short_cmd');
			$command->cmd_type = Input::get('type');
			$command->template_id = $templateId;
			$command->save();

			$arguments = Input::get('arguments');
			for($i = 0; $i < count($arguments); ++$i) {
				$argument = new Argument();
				$argument->name = $arguments[$i]['name'];
				$argument->type = $arguments[$i]['type'];
				$argument->default = $arguments[$i]['default'];
				$argument->minimum = $arguments[$i]['min'];
				$argument->maximum = $arguments[$i]['max'];
				$argument->command_id = $command->id;

				$argument->save();
			}
		});
		DB::commit();

		return Response::json([
			'id' => $command->id,
			'name' => $command->name,
			'short_cmd' => $command->short_cmd,
			'cmd_type' => $command->cmd_type,
			'template_id' => $command->template_id,
			'created_at' => $command->created_at->format('c')
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $templateId
	 * @param  int  $commandId
	 * @return Response
	 */
	public function show($templateId, $commandId)
	{
		$command = Auth::user()->commands()
			->where('commands.template_id', '=', $templateId)
			->where('commands.id', '=', $commandId)
			->with('arguments')
			->get()->first();

		return Response::json($command, 200);
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
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($templateId, $commandId)
	{
		$command = Auth::user()->commands()
			->where('template_id', '=', $templateId)
			->where('commands.id', '=', $commandId)
			->get()->first();

		$command->delete();

		return Response::make('OK', 200);
	}
}
