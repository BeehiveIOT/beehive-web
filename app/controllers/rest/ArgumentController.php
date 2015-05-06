<?php
namespace Controllers\Rest;

use Beehive\Repo\Argument\ArgumentRepo;
use Beehive\Service\Validation\ArgumentValidator;
use Input, Response;

class ArgumentController extends RestController
{
    protected $argumentRepo;
    protected $validator;

    public function __construct(ArgumentRepo $argumentRepo, ArgumentValidator $validator)
    {
        $this->argumentRepo = $argumentRepo;
        $this->validator = $validator;
    }

    public function index($templateId, $commandId)
    {
        $arguments = $this->argumentRepo->getByCommand($commandId);

        return Response::json($arguments, 200);
    }

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

    public function show($templateId, $commandId, $argumentId)
    {
        $argument = $this->argumentRepo->get($argumentId);
        return Response::json($argument, 200);
    }

    public function update($templateId, $commandId, $argumentId)
    {
        return Response::json(['status'=>'Not implemented'], 501);
    }

    public function destroy($templateId, $commandId, $argumentId)
    {
        if ($this->argumentRepo->delete($argumentId)) {
            return Response::make(['status'=>'ok'], 200);
        }
        return Response::make(['status'=>'error'], 400);
    }
}
