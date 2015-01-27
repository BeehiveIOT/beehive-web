<?php
namespace Beehive\Repo\Auth;

use Beehive\Repo\Repository;

interface AuthRepo extends Repository {
    public function getToken($access_token);
    public function validateRestToken($access_token);
}
