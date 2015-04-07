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
            ->with('arguments')
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

    public function executeCommand($id, $topic, array $arguments=[])
    {
        $commandArguments = $this->argumentRepo->getByCommand($id);
        $argumentData = [];
        foreach($arguments as $item) {
            $item['valid'] = false;
            $value = isset($item['value']) ? $item['value'] : '';

            foreach($commandArguments as $argument) {
                if ($argument->id == $item['argument_id']) {
                    if ($argument->type == 'number') {
                        if (!$this->isFloat($value)) {
                            // print_r($argument->id .' -> not float = ' . gettype($value) . '->' . $value . '<br>');
                            break;
                        }
                        $value = floatval($value);
                        if ($value > $argument->maximum || $value < $argument->minimum) {
                            // print_r($argument->id .' -> not range');
                            break;
                        }
                        $item['value'] = $value;
                    } else if ($argument->type == 'string') {
                        if (!$value) {
                            print_r($argument->id .' -> set default');
                            $item['value'] = $argument->default;
                        }
                    }
                    $item['valid'] = true;
                    $argumentData[$argument->name] = $item['value'];
                    break;
                }
            }
            if (!$item['valid']) {
                return 0;
            }
        }

        $command = parent::get($id);
        $data = [];
        $data['cmd'] = $command->short_cmd;
        foreach($argumentData as $key => $value) {
            $data[$key] = $value;
        }
        $data['time'] = \Carbon\Carbon::now()->timestamp;


        $this->bridge->publish($topic, $data);
        return $data['time'];
    }

    private function isFloat($value)
    {
        preg_match('/^-?(?:\d+|\d*\.\d+)$/', $value, $matches);

        return count($matches) > 0;
    }

}
