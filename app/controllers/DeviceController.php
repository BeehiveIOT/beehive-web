<?php
class DeviceController extends BaseController {
    public function getJson($id) {
        $device = Device::select(['id', 'name', 'description', 'communication_type'])
            ->findOrFail($id);
        $communicationTypes = CommunicationType::select(['code', 'name'])->get();
        $device->communication_types = $communicationTypes;

        return Response::json($device, 200);
    }

    public function getCommands($id) {
        $commands = Command::where('device_id', '=', $id)
            ->select(['id','name', 'short_cmd', 'device_id'])->findOrFail();

        return Response::json($commands, 200);
    }

    public function create() {
        $model = new Device();

        return View::make('device.create')
            ->with('model', $model)
            ->with('method', 'post');
    }

    public function doCreate() {
        $rules = ['name'=>'required|min:3',
            'communication_type'=>'exists:communication_types,code'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }
        $device = new Device();
        $device->name = Input::get('name');
        $device->communication_type = Input::get('communication_type');
        $device->description = Input::get('description');
        $device->user_id = Auth::user()->id;
        $device->save();

        return Redirect::to("models/$device->id/edit");
    }

    public function edit($id) {
        $device = Device::findOrFail($id);
        // Blade::setContentTags('<%', '%>');
        // Blade::setEscapedContentTags('<%%', '%%>');

        return View::make('device.edit')
            ->with('model', $device);
    }

    public function doEdit($id) {
        $rules = ['name'=>'required|min:3',
            'communication_type'=>'exists:communication_types,code'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json([
                'status'=>'nok',
                'message'=>'Invalid information'
            ], 401);
        }
        $device = Device::findOrFail($id);
        $device->name = Input::get('name');
        $device->communication_type = Input::get('communication_type');
        $device->description = Input::get('description');
        $device->save();

        return Response::json([
            'status'=>'ok',
            'message'=>'saved successfully'
        ], 200);
    }

}
