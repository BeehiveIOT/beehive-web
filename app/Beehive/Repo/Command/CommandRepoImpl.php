<?php
namespace Beehive\Repo\Command;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;

class CommandRepoImpl extends GenericRepository implements CommandRepo {
    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function getByTemplate($template_id, array $columns=['commands.*']) {
        return $this->model
            ->where('template_id', '=', $template_id)
            ->get($columns)
            ->all();
    }
}
