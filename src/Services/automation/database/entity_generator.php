<?php

use App\Database\PlainConnection;
use App\Services\automation\database\EntityGeneratorHelper;

require_once __DIR__ . "/../../../../vendor/autoload.php";


// colors
$openColor = "\033";
$closeColor = "\033[0m";
$red = "[31m";
$green = "[32m";

if (!isset($argv[1])) {
    echo "Please provide table name\n";
    exit;
}

$namespace_dir = "App\Database\Entities";

function from_snake_to_camel($table_name): string
{
    $explodedParts = explode('_', $table_name);
    $camelCaseName = "";
    foreach($explodedParts as $part)
        $camelCaseName .= ucfirst($part);

    return $camelCaseName;
}

function modify_to_entity_name($camel_case_string): string
{
    if ($camel_case_string[-1] == 's')
        return substr($camel_case_string, 0, strlen($camel_case_string) - 1);
}


// CHOOSING TABLE
$table_name = $argv[1];
$q = mysqli_query(PlainConnection::connection(), "SHOW TABLES");
$table_names = [];
while($row = mysqli_fetch_array($q))
    $table_names[] = $row[0];

if (!in_array($table_name, $table_names)) {
    echo "$openColor$red" ."Table " . $table_name . " doesn't exists, please choose one of below mentioned.\n" . "$closeColor";
    echo "Red ones are not created, but to be more sure please check " . $namespace_dir . ".\n\n";
    $table_number = 1;
    foreach($table_names as $table_name) {
        $classNameAndNamespace = $namespace_dir . "\\" . $class_name = modify_to_entity_name(from_snake_to_camel($table_name));
        if (class_exists($classNameAndNamespace)) {
            echo $table_number . ": " . $table_name . "\n";
            ++$table_number;
        } else {
            echo "$openColor$red" . $table_number . ": " . $table_name .  "$closeColor" . "\n";
            ++$table_number;
        }
    }

    exit;
}

// CHECKING ENTITY EXISTENCE
$class_name = modify_to_entity_name(from_snake_to_camel($table_name));
if (class_exists($namespace_dir . "\\" . $class_name)) {
    echo "Entity for " . $table_name . " already exists under " . $class_name . " class name!\n"
        . "Please choose table name which does not exists.\n";
    exit;
}

// CRATING ENTITY BASED ON CHOSEN TABLE
// Header
$header = "<?php\nnamespace " . $namespace_dir . ";\n";

$class_annotation =
    <<<PHP
/**
 * @Entity
 * @Table(name="$table_name")
 */
PHP;

$class_def =
    <<<PHP
class $class_name 
{
PHP;

$entity = $header . "\n" . $class_annotation . "\n" . $class_def . "\n";

// Property Addition
$description = mysqli_query(PlainConnection::connection(),"DESCRIBE $table_name");
while ($row = mysqli_fetch_assoc($description)) {
    $helper = new EntityGeneratorHelper($row);
    $entity .= $helper->createAnnotation();
    $entity .= $helper->createProperty();
}

// Getter and Setter
$description = mysqli_query(PlainConnection::connection(),"DESCRIBE $table_name");
while ($row = mysqli_fetch_assoc($description)) {
    $helper = new EntityGeneratorHelper($row);
    $entity .= $helper->createGettersAndSetters();
}
// close block
$entity .= "}\n";

file_put_contents(__DIR__ . "/../../../Database/Entities/" . $class_name . ".php", $entity, FILE_APPEND);
