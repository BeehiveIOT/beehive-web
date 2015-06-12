<?php
namespace Beehive\Repo\Device;

use Beehive\Repo\Repository;

interface DeviceRepo extends Repository {

    public function getAllByUser($id, array $columns=['devices.*']);
    public function getByUser($device_id, $user_id, array $columns=['devices.*']);
    public function getByTemplate($templateId, array $columns=['devices.*'], array $extra);
    public function isAdmin($id, $userId);
    public function canRead($id, $userId);
    public function canEdit($id, $userId);
    public function canExecute($id, $userId);
    public function getPermissions($id, array $extra=[]);
    public function addAdmin($id, array $data=[]);
    public function removeAdmin($deviceId, $userId);
}
