<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class MemoryRepository extends EntityRepository
{
    const TABLE_NAME = "memories";
    use RepositoryTrait;
}