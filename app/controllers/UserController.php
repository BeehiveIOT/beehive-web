<?php
class UserController extends BaseController {
    public function index() {
        $user = Auth::user();

        return View::make('profile.index')
            ->with('model', $user);
    }

    public function get($username) {
        return $username;
    }

    public function edit() {
        $user = Auth::user();

        return View::make('profile.edit')
            ->with('model', $user);
    }

    public function doEdit() {
        $rules = [
            'name'=>'required|min:3|max:150',
            'website'=>'url',
            'country'=>'required|exists:countries,code'
        ];

        $user = Auth::user();
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('profile/edit')
                ->with('model', $user)
                ->withErrors($validator);
        }

        $user->name = Input::get('name');
        $user->country = Input::get('country');
        $user->website = Input::get('website');
        $user->save();

        return Redirect::to('profile/edit')
            ->with('model', $user)
            ->with('message', 'Changes saved successfully');
    }

    public function doChangePassword() {
        $password = Input::get('password');
        $newpassword = Input::get('newpassword');
        $confirm = Input::get('confirm');

        $user = Auth::user();
        $credentials = ['username'=>Auth::user()->username, 'password'=>$password];
        if (!Auth::validate($credentials)) {
            return Redirect::to('profile/edit')
                ->with('error', 'Invalid password')
                ->with('model', $user);
        }

        if ($newpassword != $confirm) {
            return Redirect::to('profile/edit')
                ->with('error', 'Your new password and confirmation are different')
                ->with('model', $user);
        }

        $user->password = Hash::make($newpassword);
        $user->save();

        return Redirect::to('profile/edit')
            ->with('model', $user)
            ->with('message', 'Password updated successfully');
    }

    public function uploadImage() {
        $res = $this->uploadImageFile(Input::file('picture_url'));

        if ($res['status'] === 'ok') {
            $user = Auth::user();
            $user->picture_url = $res['fileName'];
            $user->save();
        }

        return [
            'status' => $res['status'],
            'fileName'=> $res['fileName'],
        ];
    }
}
