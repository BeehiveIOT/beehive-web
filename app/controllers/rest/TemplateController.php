<?php
namespace Controllers\Rest;

use Beehive\Repo\Template\TemplateRepo;
use Beehive\Service\Validation\TemplateValidator;
use Input, Response;

class TemplateController extends RestController
{
    protected $templateRepo;
    protected $validator;

    public function __construct(TemplateRepo $templateRepo, TemplateValidator $templateValidator)
    {
        $this->templateRepo = $templateRepo;
        $this->validator = $templateValidator;
    }

    public function index()
    {
        $columns = ['id', 'name', 'description'];
        $templates = $this->templateRepo->getAllByUser(parent::id(), $columns);

        return Response::json($templates, 200);
    }

    public function store()
    {
        $data = Input::all();
        if (!$this->validator->with($data)->passes()) {
            return Response::json($this->validator->errors(), 400);
        }

        $extra = ['user_id'=>parent::id()];
        $template = $this->templateRepo->create($data, $extra);

        return Response::json($template, 200);
    }

    public function show($id)
    {
        $columns = ['id', 'name', 'description'];
        if (!$template = $this->templateRepo->getByUser($id, parent::id(), $columns)) {
            return Response::json(['status'=>['Template not found']], 404);
        }

        return $template;
    }

    public function update($id)
    {
        $data = Input::all();
        if (!$this->validator->with($data)->passes()) {
            return Response::json($this->validator->errors(), 400);
        }

        try {
            $extra = ['user_id'=>parent::id()];
            $template = $this->templateRepo->update($id, $data, $extra);

            return Response::json($template, 200);
        }
        catch(BeehiveException $e) {
            return Response::json(['status'=>[$e->getMessage()]], $e->getCode());
        }
    }

    public function destroy($id)
    {
        return Response::json([
            'status' => 'Not implemented'
        ], 501);
    }
}
