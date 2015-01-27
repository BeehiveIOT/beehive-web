<?php
namespace Beehive\Repo\Argument;

use Beehive\Repo\Repository;

interface ArgumentRepo extends Repository {
    public function getByCommand($command_id, array $columns=['arguments.*']);
}
