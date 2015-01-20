<?php
use Beehive\Repo\Command\CommandRepo;

class CommandController extends \BaseController
{
	protected $commandRepo;

	public function __construct(CommandRepo $commandRepo)
	{
		$this->commandRepo = $commandRepo;
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
		$command = Auth::user()->commands()
			->where('template_id', '=', $templateId)
			->where('commands.id', '=', $commandId)
			->get()->first();

		$command->delete();

		return Response::make('OK', 200);
	}
}
