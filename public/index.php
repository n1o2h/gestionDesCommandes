<?php

require_once  '../vendor/autoload.php';

use App\models\Client;

$e = new Client(1, "dd", "eq", "pp", "client", true);
echo $e->getId();