<?php
use Beehive\Repo\Argument\ArgumentRepo;
use Beehive\Service\Validation\ArgumentValidator;


class ArgumentController extends \BaseController
{
	protected $argumentRepo;
	protected $validator;

	public function __construct(ArgumentRepo $argumentRepo, ArgumentValidator $validator)
	{
		$this->argumentRepo = $argumentRepo;
		$this->validator = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($templateId, $commandId)
	{
		$arguments = $this->argumentRepo->getByCommand($commandId);

		return Response::json($arguments, 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($templateId, $commandId)
	{
		$data = Input::all();
		$data['command_id'] = $commandId;
		if (!$this->validator->with($data)->passes()) {
			return Response::json($this->validator->errors(), 400);
		}

		$argument = $this->argumentRepo->create($data);

		return Response::json($argument, 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($templateId, $commandId, $argumentId)
	{
		$argument = $this->argumentRepo->get($argumentId);
		return Response::json($argument, 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($templateId, $commandId, $argumentId)
	{
		return Response::json(['status'=>'Not implemented'], 501);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $commandId
	 * @param  int  $argumentId
	 * @return Response
	 */
	public function destroy($templateId, $commandId, $argumentId)
	{
		if ($this->argumentRepo->delete($argumentId)) {
			return Response::make(['status'=>'ok'], 200);
		}
		return Response::make(['status'=>'error'], 400);
	}

}
