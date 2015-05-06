<?php
namespace Controllers\Rest;

use Beehive\Repo\Command\CommandRepo;
use Beehive\Service\Validation\CommandValidator;
use Input, Response;

class CommandController extends RestController
{
    protected $commandRepo;
    protected $cmdValidator;

    public function __construct(CommandRepo $commandRepo, CommandValidator $validator)
    {
        $this->commandRepo = $commandRepo;
        $this->cmdValidator = $validator;
    }

    public function index($templateId)
    {
        $extra = ['user_id'=>parent::id()];
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
        $extra = ['user_id'=>parent::id(), 'relation'=>'arguments'];
        $command = $this->commandRepo->getByTemplate($commandId, $templateId, $extra);

        return Response::json($command, 200);
    }

    public function update($templateId, $commandId)
    {
        $data = Input::all();
        if (!$this->cmdValidator->with($data)->passes()) {
            return Response::json($this->cmdValidator->errors(), 400);
        }

        try {
            $extra = ['userId' => parent::id(), 'templateId' => $templateId];
            $command = $this->commandRepo->update($commandId, $data, $extra);

            return Response::json($command, 200);
        } catch(Exception $e) {
            return Response::json(['status'=>[$e->getMessage()]], 400);
        }
    }

    public function destroy($templateId, $commandId)
    {
        $extra = ['user_id' => parent::id(), 'template_id'=>$templateId];
        if ($this->commandRepo->delete($commandId, $extra)) {
            return Response::make(['status'=>'ok'], 200);
        }
        return Response::make(['status'=>'error'], 400);
    }
}
