<?php


namespace App\Services\Model\PartsGuru;


use App\Database\Entities\VideoCard;

class GPU extends AbstractPart
{
    /**
     * {@inheritDoc}
     */
    protected static $name = VideoCard::class;
}