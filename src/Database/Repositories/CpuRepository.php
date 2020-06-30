<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class CpuRepository extends EntityRepository
{
    const TABLE_NAME = "cpus";
    use RepositoryTrait;
}