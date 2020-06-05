<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database\Connection;

$em = Connection::getEntityManager();

$module = $em->getRepository(\App\Database\Entities\Module::class)->find(1);
echo $module->getCapacity();
