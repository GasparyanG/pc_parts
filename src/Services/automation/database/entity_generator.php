<?php

use App\Database\PlainConnection;

require_once __DIR__ . "/../../../../vendor/autoload.php";

$q = mysqli_query(PlainConnection::connection(), "DESCRIBE connectors");
while($row = mysqli_fetch_array($q)) {
    echo "{$row['Field']} - {$row['Type']}\n";
}
