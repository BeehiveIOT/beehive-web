<?php
namespace Beehive\Service\Bridge;

interface Bridge
{
    public function publish($topic, $data);
}
