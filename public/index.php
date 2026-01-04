<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\models\Client;
use App\config\DatabaseConnect;
use App\services\AuthService;

$auth = new AuthService();

#$id = $auth->registerLivreur("hicham wahid", "wahid@gmail.com", "password123");
$id = $auth->login("wahid@gmail.com", "password123", "client");
print_r($id);




