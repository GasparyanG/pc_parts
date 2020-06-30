<?php


namespace App\Database\Repositories;


use App\Database\RepositoryTrait;
use Doctrine\ORM\EntityRepository;

class VideoCardRepository extends EntityRepository
{
    const TABLE_NAME = "video_cards";
    use RepositoryTrait;
}