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
}
