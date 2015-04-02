<?php
namespace Beehive\Repo\DataStream;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;

class DataStreamRepoImpl extends GenericRepository implements DataStreamRepo
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getByTemplate($template_id, array $columns=['data_streams.*'])
    {
        $result = $this->model
            ->where('template_id', '=', $template_id)
            ->get($columns);

        return $result;
    }

    public function create(array $data, array $extra=[])
    {
        $topic_name = strtolower($data['name']);
        $topic_name = str_replace(' ', '_', $topic_name);
        $data['topic_name'] = $topic_name;


    }
}
