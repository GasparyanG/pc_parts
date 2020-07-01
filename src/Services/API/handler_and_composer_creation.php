<?php

require_once __DIR__ . "/../../../vendor/autoload.php";

$handlers = [
    \App\Services\API\JsonApi\CPUHandler::class,
    \App\Services\API\JsonApi\GPUHandler::class,
    \App\Services\API\JsonApi\CpuImageHandler::class,
    \App\Services\API\JsonApi\StorageHandler::class,
    \App\Services\API\JsonApi\PSUHandler::class,
    \App\Services\API\JsonApi\GpuImageHandler::class,
    \App\Services\API\JsonApi\MemoryHandler::class,
    \App\Services\API\JsonApi\MoboHandler::class,
    \App\Services\API\JsonApi\PcCaseHandler::class
];


// namespaces
$handlerNamespace = "\App\Services\API\JsonApi\\";
$composerNamespace = "\App\Services\API\JsonApi\\Specification\\";

// combine relationships and make unique
$relationships = [];
foreach($handlers as $handler) {
    $relationships = array_merge($relationships, array_keys($handler::$relationshipProperties));
}

$uniqueRelationships = array_unique($relationships);

// returns handlers, which are absent from HandlerFactory
if (isset($argv[1]) && $argv[1] == "factory") {
    $notInArray = [];
    foreach ($uniqueRelationships as $entityName) {
        // prepare handler name
        $handlerName = extractClassName($entityName)
            ? extractClassName($entityName) . "Handler"
            : null;

        if (!$handlerName || !class_exists($handlerNamespace . $handlerName)) continue;
        if (!in_array(ltrim($handlerNamespace, '\\') . $handlerName, \App\Services\API\JsonApi\HandlerFactory::$handlerNames))
            $notInArray[] = $handlerName;
    }

    if (count($notInArray)) {
        echo "Entities which are not in HandlerFactory:\n";
        foreach ($notInArray as $entityName)
            echo $entityName . "\n";
    } else
        echo "All handler names are included.\n";
    exit;
}

// Create files
foreach ($uniqueRelationships as $entityFQN) {
    $entityName = extractClassName($entityFQN);
    if (!$entityName)
        throw new \InvalidArgumentException($entityFQN
            . " is not correct argument for 'extractClassName' function!");

    if (!class_exists($handlerNamespace . $entityName . "Handler"))
        file_put_contents(__DIR__ . "/JsonApi/"
            . $entityName . "Handler.php", createHandlerLayout($entityName), FILE_APPEND);

    if (!class_exists($composerNamespace . $entityName . "Composer"))
        file_put_contents(__DIR__ . "/JsonApi/Specification/"
            . $entityName . "Composer.php", createComposerLayout($entityName), FILE_APPEND);
}

function extractClassName(string $entityFQN): ?string
{
    $pattern = "~.+\\\([a-zA-Z_0-9]+)$~";
    $matches = [];

    preg_match($pattern, $entityFQN, $matches);
    if (count($matches) > 0)
        return $matches[1];
    return null;
}

// HANDLER
function createHandlerLayout(string $entityName): string
{
    $handlerName = $entityName . "Handler";

    return <<<PHP
<?php


namespace App\Services\API\JsonApi;

use App\Database\Entities\\$entityName;

class $handlerName extends ResourceHandler
{
    /**
     * {@inheritDoc}
     */
    public static \$entityName = $entityName::class;

    /**
     * {@inheritDoc}
     */
    public static \$relationshipProperties = [];
}
PHP;
}

//COMPOSER
function createComposerLayout(string $entityName): string
{
    $composerName = $entityName . "Composer";

    return <<<PHP
<?php


namespace App\Services\API\JsonApi\Specification;

use App\Database\Entities\\$entityName;

class $composerName extends ResourceComposer
{
    /**
     * {@inheritDoc}
     */
    public static \$entityName = $entityName::class;
}
PHP;
}