<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class StorageRepository extends EntityRepository
{
    const TABLE_NAME = "storages";
    use RepositoryTrait;
}