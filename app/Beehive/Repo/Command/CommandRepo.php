<?php
namespace Beehive\Repo\Command;

use Beehive\Repo\Repository;

interface CommandRepo extends Repository {
    public function getByTemplate($template_id, array $columns=['commands.*']);
}
