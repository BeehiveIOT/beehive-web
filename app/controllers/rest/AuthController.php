<?php
namespace Controllers\Rest;

use Beehive\Repo\Auth\AuthRepo;
use Response, Input;
use User;

class AuthController extends RestController
{
    protected $authRepo;

    public function __construct(AuthRepo $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function auth() {
        $username = Input::get('username');
        $password = Input::get('password');

        $user = User::find(1);
        $date = $user->created_at;
        $date = $date->addMinutes(3);
        $now = new \DateTime();

        return Response::json([
            'username' => $username,
            'password' => $password,
            'date' => $date,
            'now' => $now,
            'expired' => $user->created_at > $now,
        ], 200);
    }

    public function index() {
    }
}
