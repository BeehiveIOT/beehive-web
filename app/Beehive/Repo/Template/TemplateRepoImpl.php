<?php
namespace Beehive\Repo\Template;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;

class TemplateRepoImpl extends GenericRepository implements TemplateRepo {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function getAllByUser($user_id, array $columns=['templates.*'], $relation="") {
        $query = $this->model->where('user_id', '=', $user_id);
        if (strlen($relation) > 0) {
            $query->with($relation);
        }

        return $query->get($columns)->all();
    }

    public function getByUser($id, $user_id, array $columns=['templates.*']) {
        return $this->model
            ->where('user_id','=',$user_id)
            ->where('id', '=', $id)
            ->first($columns);
    }

    public function isOwner($user_id, $template_id) {
        if ($template = $this->get($template_id)) {
            if ($template->user_id == $user_id) {
                return true;
            }
        }
        return false;
    }

    public function create(array $data, array $extra=[]) {
        $user_id = $extra['user_id'];

        $template = parent::newModelInstance();
        $template->name = $data['name'];
        $template->description = $data['description'];
        $template->user_id= $user_id;
        $template->save();

        return $template;
    }

    public function update($id, array $data, array $extra=[]) {
        $user_id = $extra['user_id'];

        if (!$template = $this->getByUser($id, $user_id)) {
            throw new \BeehiveException('Template not available for this user.', 401);
        }

        $template->name = $data['name'];
        $template->description = $data['description'];
        $template->save();

        return $template;
    }

    public function delete($id, array $extra=[]) {
        $user_id = $extra['user_id'];

        if (!$template = $this->getByUser($id, $user_id)) {
            throw new \BeehiveException('Template not available for this user.', 401);
        }

        return $template->delete();
    }
}
