<?php


namespace App\Services\Model\PartsGuru;


use App\Services\API\JsonApi\Specification\Resource;

abstract class AbstractPart
{
    const NAME = "name";

    /**
     * @var string
     */
    protected static $name = "";

    public function isUsed(string $name): bool
    {
        return static::$name === $name;
    }

    public function productName(array $data): ?string
    {
        return $data[Resource::DATA][Resource::ATTRIBUTES][self::NAME] ?? null;
    }
}