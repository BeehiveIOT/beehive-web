<?php
use Beehive\Repo\Command\CommandRepo;
use Beehive\Service\Validation\CommandValidator;
use Beehive\Service\Validation\ArgumentValidator;

class CommandController extends \BaseController
{
	protected $commandRepo;
	protected $cmdValidator;
	protected $argValidator;

	public function __construct(
		CommandRepo $commandRepo,
		CommandValidator $cmdValidator,
		ArgumentValidator $argValidator)
	{
		$this->commandRepo = $commandRepo;
		$this->cmdValidator = $cmdValidator;
		$this->argValidator = $argValidator;
	}

	public function index($templateId)
	{
		$extra = ['user_id'=>Auth::id()];
		$commands = $this->commandRepo->getAllByTemplate($templateId, $extra);

		return Response::json($commands, 200);
	}

	public function store($templateId)
	{
		$data = Input::all();
		if (!$this->cmdValidator->with($data)->passes()) {
			return Response::json($this->cmdValidator->errors(), 400);
		}

		$extra = ['template_id' => $templateId];
		$command = $this->commandRepo->create($data, $extra);

		return Response::json($command, 200);
	}

	public function show($templateId, $commandId)
	{
		$extra = ['user_id'=>Auth::id(), 'relation'=>'arguments'];
		$command = $this->commandRepo->getByTemplate($commandId, $templateId, $extra);

		return Response::json($command, 200);
	}

	public function update($id)
	{
		//
	}

	public function destroy($templateId, $commandId)
	{
		$extra = ['user_id' => Auth::id(), 'template_id'=>$templateId];
		if ($this->commandRepo->delete($commandId, $extra)) {
			return Response::make(['status'=>'ok'], 200);
		}
		return Response::make(['status'=>'error'], 400);
	}

	private function validateArguments($arguments) {
		for($i = 0; $i < count($arguments); $i++) {
			if (!$this->argValidator->with($arguments[$i])->passes()) {
				return false;
			}
		}

		return true;
	}
}
