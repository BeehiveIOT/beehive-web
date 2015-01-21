<?php
namespace Beehive\Repo\Argument;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;

class ArgumentRepoImpl extends GenericRepository implements ArgumentRepo {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function create(array $data, array $extra=[]) {
        $argument = $this->newModelInstance();
        $argument->name = $data['name'];
        $argument->type = $data['type'];
        $argument->default = isset($data['default']) ? $data['default'] : null;
        $argument->maximum = isset($data['maximum']) ? $data['maximum'] : null;
        $argument->minimum = isset($data['minimum']) ? $data['minimum'] : null;
        $argument->command_id = $data['command_id'];
        $argument->save();

        return $argument;
    }
}
