<?php
namespace Controllers\Rest;

use Tymon\JWTAuth\Exceptions\JWTException;
use Response, Input, JWTAuth;

class AuthController extends RestController
{
    public function index() {
        return 'meg';
    }

    public function authenticate()
    {
        $credentials = Input::only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return Response::json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return Response::json(['error' => 'could_not_create_token'], 500);
        }

        return Response::json(compact('token'));
    }
}
