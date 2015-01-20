<?php

use Beehive\Repo\Template\TemplateRepo;
use Beehive\Service\Validation\TemplateValidator;

class TemplateController extends \BaseController {
	protected $templateRepo;
	protected $validator;

	public function __construct(
		TemplateRepo $templateRepo,
		TemplateValidator $validator)
	{
		$this->templateRepo = $templateRepo;
		$this->validator = $validator;
	}

	public function page()
	{
		return View::make('template.index');
	}

	public function index() {
		$columns = ['id', 'name', 'description'];
		$templates = $this->templateRepo->getAllByUser(Auth::id(), $columns, 'commands');

		return Response::json($templates, 200);
	}

	public function store()
	{
		$data = Input::all();
		if (!$this->validator->with($data)->passes()) {
			return Response::json($this->validator->errors(), 400);
		}

		$extra = ['user_id'=>Auth::id()];
		$template = $this->templateRepo->create($data, $extra);

		return Response::json(['id'=>$template->id], 200);
	}

	public function show($id)
	{
		$columns = ['id', 'name', 'description'];
		if (!$template = $this->templateRepo->getByUser($id, Auth::id(), $columns)) {
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
			$extra = ['user_id'=>Auth::id()];
			$template = $this->templateRepo->update($id, $data, $extra);
			$result = ['id' => $template->id,'name' => $template->name,
				'description'=>$template->description];

			return Response::json($result, 200);
		}
		catch(BeehiveException $e) {
			return Response::json(['status'=>[$e->getMessage()]], $e->getCode());
		}
	}

	public function destroy($id)
	{
		$extra = ['user_id'=>Auth::id()];
		if ($this->templateRepo->delete($id, $extra)) {
			return Response::json(['message' => 'Template removed successfully.', 200]);
		}
		return Response::json(['message' => 'Template was not removed.', 400]);
	}
}
