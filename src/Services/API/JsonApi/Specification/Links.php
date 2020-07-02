<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class Links
{
    /**
     * Resource's links properties
     * @var string
     */
    const LINKS = "links";
    const FIRST = "first";
    const LAST = "last";
    const SELF = "self";
    const NEXT = "next";
    const PREV = "prev";

    /**
     * @var int
     */
    public static $page = 0;

    /**
     * @var int
     */
    public static $size = 25;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    public function __construct(string $entityName, ParameterBag $queryBag)
    {
        $this->em = Connection::getEntityManager();
        $this->entityName = $entityName;
        $this->queryBag = $queryBag;

        $this->preparePageAndSize();
    }

    public function getSize(): int
    {
        return self::$size;
    }

    public function getOffset(): int
    {
        return self::$size * self::$page;
    }

    private function preparePageAndSize(): void
    {
        $pagination = $this->queryBag->get(Resource::PAGE);

        if (!$pagination ||
            (!isset($pagination[Resource::PAGE_NUMBER])
                && !isset($pagination[Resource::PAGE_SIZE]))) return;

        if (isset($pagination[Resource::PAGE_SIZE])
            && is_numeric($pagination[Resource::PAGE_SIZE])
            && $pagination[Resource::PAGE_SIZE] > 0)
            self::$size = $pagination[Resource::PAGE_SIZE];

        if (isset($pagination[Resource::PAGE_NUMBER])
            && is_numeric($pagination[Resource::PAGE_NUMBER])
            && $pagination[Resource::PAGE_NUMBER] > 0)
            self::$page = $pagination[Resource::PAGE_NUMBER];
    }
}