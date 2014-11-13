<?php

class TemplateController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('template.index');
	}

	public function items() {
		$templates = Auth::user()
			->templates()->with('commands')
			->get(['id', 'name', 'description']);
		// print_r(DB::getQueryLog());

		return Response::json($templates, 200);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return Response::make('Ops', 404);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = ['name'=>'required|min:3'];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json($validator->messages(), 400);
		}

		$template = new Template();
		$template->name = Input::get('name');
		$template->description = Input::get('description');
		$template->user_id = Auth::user()->id;

		$template->save();

		return Response::json([
			'message'=>'ok',
			'id'=>$template->id
		], 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$template = Auth::user()->templates()
			->where('id', '=', $id)->get(['id', 'name', 'description']);
		return $template;
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
		$rules = ['name'=>'required|min:3'];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json($validator->messages(), 400);
		}

		$template = Auth::user()->templates()
			->where('templates.id','=',$id)->firstOrFail();

		$template->name = Input::get('name');
		$template->description = Input::get('description');
		$template->save();

		return Response::json([
			'id'=>$template->id,
			'name'=>$template->name,
			'description'=>$template->description
		], 200);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$template = Auth::user()->templates()
			->where('templates.id', '=', $id)->firstOrFail();

		$template->delete();

		return Response::json([
			'message' => 'Template removed successfully.'
		]);
	}
}
