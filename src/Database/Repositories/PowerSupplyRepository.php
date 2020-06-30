<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class PowerSupplyRepository extends EntityRepository
{
    const TABLE_NAME = "power_supplies";
    use RepositoryTrait;
}