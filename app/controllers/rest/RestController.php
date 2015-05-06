<?php
namespace Controllers\Rest;

use JWTAuth;

class RestController extends \Controller
{
    protected function getAuthUser()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
          throw new \Exception('user not available');
        }

        return $user;
    }

    protected function id()
    {
        $user = $this->getAuthUser();
        return $user->id;
    }
}
