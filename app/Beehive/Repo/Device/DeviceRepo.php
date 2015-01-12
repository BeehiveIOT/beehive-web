<?php
namespace Beehive\Repo\Device;

use Beehive\Repo\Repository;

interface DeviceRepo extends Repository {

    public function getByUser($id, array $columns=['devices.*']);
    public function createFor($user_id, array $data);
}
