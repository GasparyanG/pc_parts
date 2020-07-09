<?php


namespace App\Services\API\JsonApi;


use App\Database\Connection;
use App\Services\API\JsonApi\Specification\Relationship;
use App\Services\API\JsonApi\Specification\Resource;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class ResourceHandler
{
    const PRICE = "price";
    const IMAGE = "image";

    /**
     * @var null|string
     */
    public static $entityName = null;

    /**
     * @var null|string
     */
    public static $imageEntityName = null;

    /**
     * @var string
     */
    public static $partImageDirectory = "/public/photos/product";

    /**
     * @var null|string
     */
    public static $priceEntityName = null;

    /**
     * @var null|string
     */
    public static $assocName = null;

    /**
     * One Day
     * @var int
     */
    private static $priceTimeInterval = 60 * 60 * 24;

    /**
     * @var array
     */
    protected static $relationshipProperties = [];

    /**
     * @var EntityRepository
     */
    protected $repo;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct()
    {
        $this->em = Connection::getEntityManager();
        $this->repo = $this->em->getRepository(static::$entityName);
    }

    public function isUsed(string $entityName): bool
    {
        return static::$entityName === $entityName;
    }

    /**
     * @param int $id
     * @return array
     */
    public function attributes(int $id): array
    {
        $attr = $this->repo->findAsArray($id);

        // add essential attributes as well
        // price
        if (static::$priceEntityName) {
            $priceRepo = $this->em->getRepository(static::$priceEntityName);
            $price = $priceRepo->findLastLowestPrice($id, self::$priceTimeInterval, static::$assocName);

            $attr[self::PRICE] = $price ? $price: null ;
        }

        // image
        if (static::$imageEntityName) {
            $imageRepo = $this->em->getRepository(static::$imageEntityName);
            $imageFileName = $imageRepo->findImageName($id);
            $attr[self::IMAGE] = $imageFileName ? self::$partImageDirectory . "/" . $imageFileName: null;
        }

        return $attr;
    }

    /**
     * @param int $id
     * @return array
     */
    public function relationships(int $id): array
    {
        $entity = $this->em->getRepository(static::$entityName)->find($id);
        if (!$entity) return [];

        $relationships = [];
        foreach (static::$relationshipProperties as $entityName => $methodName)
            $relationships[] = $this->relationshipWith($entity, $entityName, $methodName);

        return $relationships;
    }

    protected function relationshipWith($entity, string $className, string $methodName): array
    {
        if (!$entity) return [];

        $relationship = new Relationship();
        $tableName = $this->em->getClassMetadata($className)->getTableName();
        $relationship->setType($tableName);

        $data = [];

        $relationships = $entity->$methodName();
        if (is_iterable($relationships))
            foreach ($relationships as $relEntity)
                $this->prepareRelData($relEntity, $data, $tableName);
        else if ($relationships)
            $this->prepareRelData($relationships, $data, $tableName);

        $relationship->setData($data);
        $relationship->arrayRepresentation();
        return $relationship->getRepresentation();
    }

    protected function prepareRelData($relEntity, array& $container, string $tableName): void
    {
        $singleItemData = [];
        $singleItemData[Resource::TYPE] = $tableName;
        $singleItemData[Resource::ID] = $relEntity->getId();
        $container[] = $singleItemData;
    }

    protected function tableName(string $entity): ?string
    {
        return $this->em->getClassMetadata($entity)->getTableName();
    }

    public function included(?string $relToInclude, int $id): array
    {
        $relToIncludeArr = explode(',', $relToInclude);
        $entity = $this->em->getRepository(static::$entityName)->find($id);

        if (!$entity) return [];

        $dataToReturn = [];

        foreach ($relToIncludeArr as $rel) {
            [$methodName, $relEntity] = $this->getMethodName($rel);
            // TODO: notify somehow
            // user may request for non-existing relationship
            if (!$methodName) continue;
            $relationshipResults = $entity->$methodName();
            $handler = HandlerFactory::create($relEntity);

            if (is_iterable($relationshipResults))
                foreach ($relationshipResults as $relationshipResult)
                    $this->prepareRelationship($relationshipResult, $dataToReturn, $handler);
            else if ($relationshipResults)
                $this->prepareRelationship($relationshipResults, $dataToReturn, $handler);
        }

        return $dataToReturn;
    }

    protected function prepareRelationship($relationship, array& $container, ResourceHandler $handler): void
    {
        $resourceToInclude = [];
        // resource preparation
        $resourceToInclude[Resource::ID] = $relationship->getId();
        $resourceToInclude[Resource::TYPE] = $this->tableName(get_class($relationship));
        $resourceToInclude[Resource::ATTRIBUTES] = $handler->attributes($relationship->getId());

        $container[] = $resourceToInclude;
    }

    protected function getMethodName(string $relName): array
    {
        foreach (static::$relationshipProperties as $entityName => $methodName)
            if ($relName === $this->tableName($entityName))
                return [$methodName, $entityName];

        return [null, null];
    }
}