<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class GpuImageRepository extends EntityRepository
{
    use RepositoryTrait;
}