<?php
namespace Beehive\Repo\Command;

use Illuminate\Database\Eloquent\Model;
use Beehive\Repo\GenericRepository;
use Beehive\Repo\Template\TemplateRepo;
use Beehive\Repo\Argument\ArgumentRepo;
use Beehive\Service\Bridge\Bridge;
use \DB;

class CommandRepoImpl extends GenericRepository implements CommandRepo
{
    protected $templateRepo;
    protected $argumentRepo;
    protected $bridge;

    public function __construct(
        Model $model, TemplateRepo $templateRepo,
        ArgumentRepo $argRepo, Bridge $bridge)
    {
        $this->model = $model;
        $this->templateRepo = $templateRepo;
        $this->argumentRepo = $argRepo;
        $this->bridge = $bridge;
    }

    public function getAllByTemplate(
        $template_id, array $extra=[], array $columns=['commands.*'])
    {
        if (isset($user_id)) {
            $user_id = $extra['user_id'];
            if(!$this->templateRepo->isOwner($template_id, $user_id)) {
                return [];
            }
        }

        return $this->model
            ->where('template_id', '=', $template_id)
            ->get($columns)
            ->all();
    }

    public function getByTemplate(
        $id, $template_id, array $extra=[], array $columns=['commands.*'])
    {
        if (isset($user_id)) {
            $user_id = $extra['user_id'];
            if(!$this->templateRepo->isOwner($template_id, $user_id)) {
                return null;
            }
        }

        $relation = isset($extra['relation']) ? $extra['relation'] : '';
        $query = $this->model
            ->where('commands.template_id','=',$template_id)
            ->where('commands.id','=',$id);

        if (count($relation) > 0) {
            $query->with($relation);
        }

        return $query->first($columns);
    }

    public function create(array $data, array $extra=[])
    {
        $argRepo = $this->argumentRepo;
        $command = $this->newModelInstance();
        if (!isset($extra['template_id'])) {
            return null;
        }
        $template_id = $extra['template_id'];
        $arguments = isset($data['arguments']) ? $data['arguments'] : [];

        DB::transaction(function()use($command, $argRepo, $template_id, $data, $arguments) {
            $command->name = $data['name'];
            $command->short_cmd = $data['short_cmd'];
            $command->cmd_type = $data['type'];
            $command->template_id = $template_id;
            $command->save();

            for($i = 0; $i < count($arguments); $i++) {
                $arguments[$i]['command_id'] = $command->id;
                $argRepo->create($arguments[$i]);
            }
        });
        DB::commit();

        return $command;
    }

    public function delete($id, array $extra=[])
    {
        if (isset($data['user_id']) && isset($data['template_id'])) {
            if (!$command = $this->getByTemplate($id, $extra)) {
                return false;
            }
            return $command->delete();
        }

        return parent::delete($id);
    }

    public function executeCommand($id, array $arguments=[])
    {
        // TODO: check permission
        $command = parent::get($id);
        $data = [
            'cmd' => $command->short_cmd,
            'time' => \Carbon\Carbon::now()->timestamp
        ];

        $this->bridge->publish('car/command', $data);
    }
}
