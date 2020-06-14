<?php


namespace App\Services\automation\database;


class EntityGeneratorHelper
{
    const FIELD = "Field";
    const TYPE = "Type";
    const NULLABLE = "Null";
    const KEY = "Key";
    const DEFAULT = "Default";
    const EXTRA = "Extra";

    private $filedName;
    private $type;
    private $key;
    private $default;
    private $null;
    private $extra;

    static $typeMapping = [
        "int" => "int",
        "varchar" => "string",
        "boolean" => "bool",
        "float" => "float"
    ];

    static $annotationTypeMapping = [
        "int" => "integer",
        "bool" => "boolean"
    ];

    public function __construct(array $fieldData)
    {
        $this->filedName = $fieldData[self::FIELD];
        $this->type = $fieldData[self::TYPE];
        $this->null = $fieldData[self::NULLABLE];
        $this->key = $fieldData[self::KEY];
        $this->default = $fieldData[self::DEFAULT];
        $this->extra = $fieldData[self::EXTRA];
    }

    public function createAnnotation(): string
    {
        $annotation = "";

        $type = $this->extractType();
        $annotationType = $this->annotationType($type);
        // nulllable
        $nullable = ($this->null === "YES") ? "|null": "";
        if ($this->key === "MUL") {
            $annotation .= <<<PHP
    /**
     * @ManyToOne(targetEntity="", inversedBy="")
     */
PHP;
        } else {
            $annotation .= <<<PHP
    /**
     * @var $type
     * @Column(type="$annotationType", name="$this->filedName")\n
PHP;
            if ($this->extra === "auto_increment")
                $annotation .= "\t * @GeneratedValue\n";

            $annotation .="\t */";
        }

        return $annotation;
    }

    private function annotationType(string $type): string
    {
        return isset(self::$annotationTypeMapping[$type]) ? self::$annotationTypeMapping[$type] : $type;
    }

    private function extractType(): string
    {
        foreach (self::$typeMapping as $key => $value)
            if (strpos($this->type, $key) !== false)
                return $value;
        return $this->type;
    }

    public function createProperty(): string
    {
        return "\n\tprivate $" . $this->snakeToCamelCase() . ";\n\n";
    }

    private function snakeToCamelCase(): string
    {
        $parts = explode('_', $this->filedName);
        $camelCaseName = "";
        for ($i = 0; $i<count($parts); ++$i)
            $camelCaseName .= ucfirst($parts[$i]);

        return lcfirst($camelCaseName);
    }

    public function createGettersAndSetters(): string
    {
        $getterAndSetter = "\n";
        // create getter
        $getterAndSetter .= $this->createGetter();

        // separation
        $getterAndSetter .= "\n";

        // create setter
        $getterAndSetter .= $this->createSetter();

        return $getterAndSetter;
    }

    private function createGetter(): string
    {
        $typeToReturn = $this->extractType();
        // doctype to return
        $doctypeNullConcat = $concatNull = $this->null === "YES" ? "null|": "";
        $doctypeToReturn = $doctypeNullConcat . $typeToReturn;

        $phpDoc = <<<PHP
    /**
     * @return $doctypeToReturn
     */
PHP;

        // method type
        $concatNull = $this->null === "YES" ? "?": "";
        $methodTypeToReturn = $concatNull . $typeToReturn;
        // signature
        $getter = "\tpublic function ";
        $getter .= "get" . ucfirst($this->snakeToCamelCase()) . "(): $methodTypeToReturn";

        // body
        $propertyName = $this->snakeToCamelCase();
        $body = "\t{\n";
        $body .= "\t\treturn $" . "this->$propertyName;\n";
        $body .= "\t}\n";

        $getter = $phpDoc . "\n" . $getter . "\n" . $body;
        return $getter;
    }

    private function createSetter(): string
    {
        $typeToGet = $this->extractType();
        // doctype to return
        $doctypeNullConcat = $concatNull = $this->null === "YES" ? "null|": "";
        $doctypeToGet = $doctypeNullConcat . $typeToGet;

        $phpDoc = <<<PHP
    /**
     * @param $doctypeToGet
     */
PHP;

        // method type to get
        $concatNull = $this->null === "YES" ? "?": "";
        $methodTypeToGet = $concatNull . $typeToGet;

        // signature
        $propertyName = $this->snakeToCamelCase();
        $setter = "\tpublic function ";
        $setter .= "set" . ucfirst($this->snakeToCamelCase()) . "($methodTypeToGet $" . "$propertyName): void";

        // body
        $body = "\t{\n";
        $body .= "\t\t$" . "this->$propertyName = $" . "$propertyName;\n";
        $body .= "\t}\n";

        $setter = $phpDoc . "\n" . $setter . "\n" . $body;
        return $setter;
    }
}