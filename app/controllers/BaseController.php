<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Helper function in order to upload an image
	 * in the future it will use imagine library for resizing
	 * @param  [laravel file] $file [the request file]
	 * @return [array]  status=>ok|error, fileName=>$name
	 */
	protected function uploadImageFile($file) {
        $extensions = ['png', 'jpeg', 'jpg', 'gif'];
        $maxSize = 1024 * 2000;// 200kb supposedly
        $path = public_path() . "/uploads/avatars";
        $status = null;

        $fileName = null;
        $status = null;
        $ext = $file->guessClientExtension();
        $size = $file->getClientSize();
        $name = GUID::generate() . ".$ext";

        if(in_array($ext, $extensions) and $size < $maxSize) {
            if ($file->move($path, $name)) {
                $status = 'ok';
            } else {
                $status = 'error';
            }
        } else {
            $status = 'error';
        }

        return ['status' => $status, 'fileName' => $name];
    }

}
