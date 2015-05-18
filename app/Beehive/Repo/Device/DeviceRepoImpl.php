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
        $device->administrators()->attach($user_id);

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

    public function getPermissions($id, array $extra=[])
    {
        $result = [];
        $device = parent::get($id);
        $admins = $device->administrators()->get();
        $userId = null;
        if (isset($extra['userId'])) {
            $userId = $extra['userId'];
        }

        foreach($admins as $admin) {
            $item = [
                'user_id' => $admin->id,
                'name' => $admin->name,
                'can_read' => $admin->pivot->can_read == 1 ? true : false,
                'can_update' => $admin->pivot->can_update == 1 ? true : false,
                'can_delete' => $admin->pivot->can_delete == 1 ? true : false,
                'owner' => false
            ];
            if ($userId) {
                $item['owner'] = $userId == $admin->id;
            }

            $result[] = $item;
        }
        return $result;
    }
}
