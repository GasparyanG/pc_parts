<?php


namespace App\Database\Repositories;


use Doctrine\ORM\EntityRepository;

class ColorRepository extends EntityRepository
{
    const TABLE_NAME = "colors";
    const COLOR_SEPARATOR = "' / '";
}