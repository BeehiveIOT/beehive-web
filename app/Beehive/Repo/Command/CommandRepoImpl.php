<?php
namespace Beehive\Repo\Command;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;
use Beehive\Repo\Template\TemplateRepo;

class CommandRepoImpl extends GenericRepository implements CommandRepo
{
    protected $templateRepo;

    public function __construct(Model $model, TemplateRepo $templateRepo)
    {
        $this->model = $model;
        $this->templateRepo = $templateRepo;
    }

    public function getAllByTemplate($template_id, array $extra=[], array $columns=['commands.*'])
    {
        $user_id = isset($extra['user_id']) ? $extra['user_id'] : null;
        if($user_id && !$this->templateRepo->isOwner($template_id, $user_id)) {
            return [];
        }

        return $this->model
            ->where('template_id', '=', $template_id)
            ->get($columns)
            ->all();
    }

    public function getByTemplate(
        $id, $template_id, array $extra=[], array $columns=['commands.*'])
    {
        $user_id = isset($extra['user_id']) ? $extra['user_id'] : null;
        $relation = isset($extra['relation']) ? $extra['relation'] : '';
        if($user_id && !$this->templateRepo->isOwner($template_id, $user_id)) {
            return null;
        }

        $query = $this->model
            ->where('commands.template_id','=',$template_id)
            ->where('commands.id','=',$id);

        if (count($relation) > 0) {
            $query->with($relation);
        }

        return $query->first($columns);
    }
}
