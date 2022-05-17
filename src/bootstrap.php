<?php

require_once  "vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv= DotEnv::createImmutable(dirname(__DIR__,1));
$dotenv->safeLoad();