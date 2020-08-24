<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Controllers\Home;

$home = new Home();
$home->get()->send();
