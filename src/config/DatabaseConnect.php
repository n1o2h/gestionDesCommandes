<?php
namespace  App\config;
use PDO;
use PDOException;

class DatabaseConnect
{
    private static ?PDO $instance = null;
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'gestioncommandes';
    private const DB_USER = 'root';
    private const DB_PASS = '';

    public function __construct(){
    }

    public static function getConnexion() : PDO{
        if(self::$instance === null){
            try{
                self::$instance = new PDO(
                    "mysql:host=" . self::DB_HOST .
                    ";dbname=" . self::DB_NAME .
                    ";charset=utf8",
                    self::DB_USER,
                    self::DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            }catch (PDOException $e){
                die("Erreur de connexion à la BDD : " . $e->getMessage());
            }
        }
        echo 'succes connesion';
        return  self::$instance;
    }
}
