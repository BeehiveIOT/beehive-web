<?php

class DevicePermissionController extends BaseController
{

    public function page($all='')
    {
        return View::make('permission.index');
    }
}
