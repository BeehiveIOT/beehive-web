<?php
use Beehive\Repo\Command\CommandRepo;

class RealTimeController extends BaseController
{
    protected $commandRepo;

    public function __construct(CommandRepo $commandRepo)
    {
        $this->commandRepo = $commandRepo;
    }

    public function publishCommand()
    {
        $rules = [
            'command_id' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json([
                'status' => 'invalid command'
            ], 400);
        }

        $this->commandRepo->executeCommand(Input::get('command_id'));

        return Response::json(['status'=>'ok'], 200);
    }
}
