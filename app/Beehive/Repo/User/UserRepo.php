<?php
namespace Beehive\Repo\User;

use Beehive\Repo\Repository;

interface UserRepo extends Repository {
    public function getByUsername($username);
}
