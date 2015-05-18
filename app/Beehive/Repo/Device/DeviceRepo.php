<?php
namespace Beehive\Repo\Device;

use Beehive\Repo\Repository;

interface DeviceRepo extends Repository {

    public function getAllByUser($id, array $columns=['devices.*']);
    public function getByUser($device_id, $user_id, array $columns=['devices.*']);
    public function getByTemplate($templateId, array $columns=['devices.*'], array $extra);
    public function isAdmin($id, $userId);
    public function getPermissions($id, array $extra=[]);
}
