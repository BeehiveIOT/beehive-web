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

    public function getByUser($id, array $columns=['devices.*']) {
        return $this->model
            ->join('device_admin as da', 'devices.id', '=', 'da.device_id')
            ->where('da.user_id', '=', $id)
            ->get($columns)
            ->all();
    }

    public function createFor($user_id, array $data) {
        if ($template_id = $data['template_id']) {
            if (!$this->templateRepo->isOwner($user_id, $template_id)) {
                throw new \BeehiveException('Invalid template id');
            }
        }

        try {
            $device = $this->newModelInstance();
            $device->name = $data['name'];
            $device->uuid = GUID::generate();
            $device->device_secret = GUID::generate();
            $device->description = $data['description'];
            $device->is_public = $data['is_public'] ? true : false;
            $device->template_id = $template_id ?: null;
            $device->save();

            // $user_id as default administrator
            $device->administrators()->attach($user_id);

            return $device;
        } catch(Exception $e) {
            throw new \BeehiveException($e->getMessage());
        }
    }
}
