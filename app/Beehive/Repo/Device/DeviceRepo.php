<?php
namespace Beehive\Repo\Device;

use Beehive\Repo\Repository;

interface DeviceRepo extends Repository {

    public function getAllByUser($id, array $columns=['devices.*']);
    public function getByUser($device_id, $user_id, array $columns=['devices.*']);
}
