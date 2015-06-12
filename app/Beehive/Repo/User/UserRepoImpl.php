<?php
namespace Beehive\Repo\User;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;

class UserRepoImpl extends GenericRepository implements UserRepo
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getByUsername($username)
    {
        $users = $this->model
            ->where('username', '=', $username)
            ->get();
        if (count($users) > 0) {
            return $users[0];
        }
        return null;
    }
}
