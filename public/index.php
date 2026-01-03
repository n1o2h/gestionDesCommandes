<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\models\Client;
use App\config\DatabaseConnect;
use App\repositories\utilisateurRepository;
use App\repositories\ClientRepository;
use App\repositories\LivreurRepository;
use App\repositories\AdminRepository;
use App\repositories\CommandeRepository;
use App\repositories\OffreRepository;
use App\repositories\VehiculeRepository;
use App\repositories\NotificationRepository;



#$pdo = DatabaseConnect::getConnexion();

$sq = new NotificationRepository();
#$sq->save("Legumes", "c'est du legume", 7);
$datetime = new DateTime('2022-01-16 12:32:49');
#$sq->save("systeme", "bienvenue dans l'application", $datetime, true, 8);
#ila drt fi boolean false ky9oli ghlt so whyy?
#$sq->update("offre", "c'est un nouveau offre", $datetime, true, 1);
echo "<pre>";
var_dump($sq->findByIdAndType(1, "offre"));
echo "</pre>";
echo '<br>';




