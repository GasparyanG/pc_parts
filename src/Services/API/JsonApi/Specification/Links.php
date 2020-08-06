<?php


namespace App\Services\API\JsonApi\Specification;


use App\Database\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

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

    // Symbolic constants
    const FIRST_PAGE = 0;

    /**
     * @var int
     */
    public static $page = 0;

    /**
     * @var int
     */
    public static $size = 5;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var ParameterBag
     */
    private $queryBag;

    /**
     * @var array
     */
    private $links = [];

    /**
     * @var Request
     */
    private $request;

    public function __construct(string $entityName, ParameterBag $queryBag)
    {
        $this->em = Connection::getEntityManager();
        $this->entityName = $entityName;
        $this->queryBag = $queryBag;
        $this->request = Request::createFromGlobals();
        $this->total = $this->em->getRepository($this->entityName)->total();

        $this->preparePageAndSize();
    }

    public function getSize(): int
    {
        return self::$size;
    }

    public function arrayRepresentation(): void
    {
        $this->links[self::SELF] = $this->self();
        $this->links[self::FIRST] = $this->first();
        $this->links[self::LAST] = $this->last();
        $this->links[self::PREV] = $this->prev();
        $this->links[self::NEXT] = $this->next();
    }

    private function self(): string
    {
        return $this->request->getUri();
    }

    private function first(): string
    {
        $queryParams = $this->queryBag->all();
        if (!isset($queryParams[Resource::PAGE][Resource::PAGE_NUMBER]))
            $queryParams[Resource::PAGE] = $this->defaults();

        $queryParams[Resource::PAGE][Resource::PAGE_NUMBER] = self::FIRST_PAGE;
        return $this->prepareUri($queryParams);
    }

    private function last(): string
    {
        $queryParams = $this->queryBag->all();
        if (!isset($queryParams[Resource::PAGE][Resource::PAGE_NUMBER]))
            $queryParams[Resource::PAGE] = $this->defaults();

        // compute last
        $last = round($this->total / self::$size);

        $queryParams[Resource::PAGE][Resource::PAGE_NUMBER] = $last;
        return $this->prepareUri($queryParams);
    }

    private function prev(): string
    {
        $queryParams = $this->queryBag->all();
        if (!isset($queryParams[Resource::PAGE][Resource::PAGE_NUMBER]))
            $queryParams[Resource::PAGE] = $this->defaults();

        $queryParams[Resource::PAGE][Resource::PAGE_NUMBER] = (int)self::$page === self::FIRST_PAGE ? self::$page : self::$page - 1;
        return $this->prepareUri($queryParams);
    }

    private function next(): string
    {
        $queryParams = $this->queryBag->all();
        if (!isset($queryParams[Resource::PAGE][Resource::PAGE_NUMBER]))
            $queryParams[Resource::PAGE] = $this->defaults();

        // compute last
        $last = round($this->total / self::$size);

        $queryParams[Resource::PAGE][Resource::PAGE_NUMBER] = (int)self::$page === (int)$last ? self::$page : self::$page + 1;
        return $this->prepareUri($queryParams);
    }

    private function prepareUri(?array $queryParams): string
    {
        $qs = $queryParams ? '?' . http_build_query($queryParams): "";
        return $this->request->getSchemeAndHttpHost().$this->request->getBaseUrl().$this->request->getPathInfo().$qs;
    }

    private function defaults(): array
    {
        $page = [];
        $page[Resource::PAGE_NUMBER] = self::$page;
        $page[Resource::PAGE_SIZE] = self::$size;

        return $page;
    }

    public function getRepresentation(): array
    {
        return $this->links;
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