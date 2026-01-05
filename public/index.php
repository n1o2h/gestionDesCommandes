<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\models\Client;
use App\config\DatabaseConnect;
use App\services\AuthService;

$auth = new AuthService();

#echo $auth->registerClient("iyad chmaili", "chmaili@gmail.com", "pass12345");
/*
 * Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1366 Incorrect integer value:
 * '' for column 'active' at row 1 in C:\wamp\www\gestionDesCommandes\src\repositories\utilisateurRepository.php:17
 * Stack trace: #0 C:\wamp\www\gestionDesCommandes\src\repositories\utilisateurRepository.php(17):
 * PDOStatement->execute(Array) #1 C:\wamp\www\gestionDesCommandes\src\services\AuthService.php(29):
 *  App\repositories\utilisateurRepository->
 * save('iyad chmaili', 'chmaili@gmail.c...', '$2y$10$X6cuCrcD...', 'client', false) #2
 *  C:\wamp\www\gestionDesCommandes\public\index.php(10): App\services\AuthService->
 * registerClient('iyad chmaili', 'chmaili@gmail.c...', 'pass12345') #3 {main} thrown in
 *  C:\wamp\www\gestionDesCommandes\src\repositories\utilisateurRepository.php on line 17
 * */





