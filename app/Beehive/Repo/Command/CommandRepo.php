<?php
namespace Beehive\Repo\Command;

use Beehive\Repo\Repository;

interface CommandRepo extends Repository {

    public function getAllByTemplate(
        $template_id, array $extra=[], array $columns=['commands.*']
    );

    public function getByTemplate(
        $id,$template_id, array $extra=[], array $columns=['commands.*']
    );

    public function executeCommand($id, array $arguments=[]);
}
