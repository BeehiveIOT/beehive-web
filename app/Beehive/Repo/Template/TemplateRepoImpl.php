<?php
namespace Beehive\Repo\Template;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;

class TemplateRepoImpl extends GenericRepository implements TemplateRepo {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function getByUser($id, array $columns=['templates.*']) {
        return $this->model
            ->where('user_id', '=', $id)
            ->get($columns)
            ->all();
    }

    public function isOwner($user_id, $template_id) {
        if ($template = $this->get($template_id)) {
            if ($template->user_id == $user_id) {
                return true;
            }
        }
        return false;
    }
}
