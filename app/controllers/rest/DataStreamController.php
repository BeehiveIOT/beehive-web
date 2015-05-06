<?php
namespace Controllers\Rest;

use Beehive\Repo\DataStream\DataStreamRepo;
use Beehive\Repo\Template\TemplateRepo;
use Beehive\Service\Validation\DataStreamValidator;
use Input, Response;

class DataStreamController extends RestController
{
    protected $dataStreamRepo;
    protected $templateRepo;
    protected $dataStreamValidator;

    public function __construct(
        DataStreamRepo $dataStreamRepo,
        TemplateRepo $templateRepo,
        DataStreamValidator $validator)
    {
        $this->dataStreamRepo = $dataStreamRepo;
        $this->templateRepo = $templateRepo;
        $this->dataStreamValidator = $validator;
    }

    public function index($templateId)
    {
        if (!$this->templateRepo->isOwner(parent::id(), $templateId)) {
            return Response::json([
                'status' => 'Template not found.'
            ], 404);
        }
        $dataStreams = $this->dataStreamRepo->getByTemplate($templateId);

        return Response::json($dataStreams, 200);
    }

    public function store($templateId)
    {
        $data = Input::only(['name', 'topic_name', 'data_type', 'unit', 'unit_symbol', 'display_type']);
        $data['template_id'] = $templateId;

        if (!$this->dataStreamValidator->with($data)->passes()) {
            return Response::json($this->dataStreamValidator->errors(), 400);
        }

        if (!$this->templateRepo->isOwner(parent::id(), $templateId)) {
            return Response::json(['status' => 'Template not found.'], 404);
        }

        $dataStream = $this->dataStreamRepo->create($data);
        return Response::json($dataStream, 200);
    }

    public function show($templateId, $dataStreamId)
    {
        if (!$this->templateRepo->isOwner(parent::id(), $templateId)) {
            return Response::json([
                'status' => 'Template not found.'
            ], 404);
        }

        if (!$dataStream = $this->dataStreamRepo->get($dataStreamId)) {
            return Response::json([
                'status' => 'Data Stream not found.'
            ], 404);
        }

        return Response::json($dataStream, 200);
    }

    public function update($templateId, $dataStreamId)
    {
        $data = Input::only(['name', 'topic_name', 'data_type', 'unit', 'unit_symbol', 'display_type']);
        $data['template_id'] = $templateId;

        if (!$this->dataStreamValidator->with($data)->passes()) {
            return Response::json($this->dataStreamValidator->errors(), 400);
        }

        if (!$this->templateRepo->isOwner(parent::id(), $templateId)) {
            return Response::json(['status' => 'Template not found.'], 404);
        }

        $dataStream = $this->dataStreamRepo->update($dataStreamId, $data);
        return Response::json($dataStream, 200);
    }

    public function destroy($templateId, $dataStreamId)
    {
        if (!$this->templateRepo->isOwner(parent::id(), $templateId)) {
            return Response::json(['status' => 'Template not found.'], 404);
        }

        if ($this->dataStreamRepo->delete($dataStreamId)) {
            return Response::json(['status'=>'ok'], 200);
        }
        return Response::json(['status'=>'error'], 200);
    }
}
