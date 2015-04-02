<?php
namespace Beehive\Repo\DataStream;

use Beehive\Repo\Repository;

interface DataStreamRepo extends Repository
{
    public function getByTemplate($template_id, array $columns=['data_streams.*']);
}
