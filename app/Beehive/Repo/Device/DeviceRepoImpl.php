<?php
namespace Beehive\Repo\Device;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;
use Beehive\Repo\Template\TemplateRepo;
use \GUID;
use \DB;

class DeviceRepoImpl extends GenericRepository implements DeviceRepo {
    protected $templateRepo;

    public function __construct(
        Model $model, TemplateRepo $templateRepo)
    {
        $this->model = $model;
        $this->templateRepo = $templateRepo;
    }

    public function getAllByUser($id, array $columns=['devices.*']) {
        return $this->model
            ->join('device_admin as da', 'devices.id', '=', 'da.device_id')
            ->where('da.user_id', '=', $id)
            ->get($columns)
            ->all();
    }

    public function getByUser($device_id, $user_id, array $columns=['devices.*']) {
        return $this->model
            ->join('device_admin as da', 'devices.id', '=', 'da.device_id')
            ->where('da.user_id', '=', $user_id)
            ->where('devices.id', '=', $device_id)
            ->first($columns);
    }

    public function getByTemplate($templateId, array $columns=['devices.*'], array $extra)
    {
        $userId = $extra['userId'];

        return $this->model
            ->join('device_admin as da', 'da.device_id', '=', 'devices.id')
            ->where('devices.template_id', '=', $templateId)
            ->where('da.user_id', '=', $userId)
            ->get($columns);
    }

    public function create(array $data, array $extra=[]) {
        $template_id = $data['template_id'];
        $user_id = $extra['user_id'];
        if (!isset($template_id) || !$this->templateRepo->isOwner($user_id, $template_id)) {
            throw new \BeehiveException('Invalid template id', 401);
        }

        $device = $this->newModelInstance();
        $device->name = $data['name'];
        $device->serial_number = GUID::generate();
        $device->device_secret = GUID::generate();
        $device->pub_key = GUID::generate();
        $device->sub_key = GUID::generate();
        $device->description = $data['description'];
        $device->is_public = $data['is_public'] ? true : false;
        $device->template_id = $template_id ?: null;
        $device->save();

        // $user_id as default administrator
        $device->administrators()->attach($user_id, [
            'can_read' => true,
            'can_edit' => true,
            'can_execute' => true,
            'owner' => true
        ]);

        return $device;
    }

    public function update($id, array $data, array $extra=[]) {
        $user_id = $extra['user_id'];

        if (!$device = $this->getByUser($id, $user_id)) {
            throw new \BeehiveException('Device not available for this user.', 401);
        }

        $device->name = $data['name'];
        $device->description = $data['description'];
        $device->is_public = $data['is_public'] ? true : false;
        $device->save();

        return $device;
    }

    public function isAdmin($id, $userId)
    {
        $data = DB::table('device_admin')
            ->where('device_id', '=', $id)
            ->where('user_id', '=', $userId)
            ->get();

        if (count($data) > 0) {
            return $data[0];
        }
        return null;
    }

    public function isOwner($id, $userId)
    {
        $item = $this->isAdmin($id, $userId);
        if ($item) {
            if ($item->owner) {
                return $item;
            }
        }
        return null;
    }

    public function canRead($id, $userId)
    {
        $item = $this->isAdmin($id, $userId);
        if ($item) {
            if ($item->can_read) {
                return $item;
            }
        }
        return null;
    }

    public function canEdit($id, $userId)
    {
        $item = $this->isAdmin($id, $userId);
        if ($item) {
            if ($item->can_edit) {
                return $item;
            }
        }
        return null;
    }

    public function canExecute($id, $userId)
    {
        $item = $this->isAdmin($id, $userId);
        if ($item) {
            if ($item->can_execute) {
                return $item;
            }
        }
        return null;
    }

    public function getPermissions($id)
    {
        $result = [];
        $device = parent::get($id);
        $admins = $device->administrators()->get();

        foreach($admins as $admin) {
            $item = [
                'id' => $admin->pivot->id,
                'user_id' => $admin->id,
                'name' => $admin->name,
                'username' => $admin->username,
                'can_read' => $admin->pivot->can_read == 1 ? true : false,
                'can_edit' => $admin->pivot->can_edit == 1 ? true : false,
                'can_execute' => $admin->pivot->can_execute == 1 ? true : false,
                'owner' => $admin->pivot->owner == 1 ? true : false,
            ];

            $result[] = $item;
        }
        return $result;
    }

    public function addAdmin($id, array $data=[])
    {
        $device = parent::get($id);
        $userId = $data['user_id'];
        $data = [
            'can_read' => true,
            'can_edit' => $data['can_edit'],
            'can_execute' => $data['can_execute'],
            'owner' => false,
        ];
        $device->administrators()->sync([$userId => $data], false);
        $data['user_id'] = $userId;

        return $data;
    }

    public function removeAdmin($deviceId, $userId)
    {
        $result = DB::table('device_admin')
            ->where('user_id', '=', $userId)
            ->where('device_id', '=', $deviceId)
            ->get();

        if (count($result) == 0) {
            return false;
        }

        if ($result[0]->owner) {
            return false;
        }

        DB::table('device_admin')
            ->where('user_id', '=', $userId)
            ->where('device_id', '=', $deviceId)
            ->delete();

        return true;
    }
}
