<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database\Connection;

$em = Connection::getEntityManager();

$entity = $em->getRepository(\App\Database\Entities\VideoCard::class)->find(50);
foreach ($entity->getGpuImages() as $Image)
    echo $Image->getFileName();
