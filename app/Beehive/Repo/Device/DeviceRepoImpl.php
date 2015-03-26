<?php
namespace Beehive\Repo\Device;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;
use Beehive\Repo\Template\TemplateRepo;
use \GUID;

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
}
