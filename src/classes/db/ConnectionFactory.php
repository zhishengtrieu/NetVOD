<?php
declare(strict_types=1);
namespace netvod\db;

class ConnectionFactory{
    public static $config;
    public static $db;

    public static function setConfig(string $file){
        try{
            self::$config = parse_ini_file($file);
        }catch(\Exception $e){
            throw new \Exception( "Erreur avec le fichier de config" );
        }
    }

    public static function makeConnection(){
        if (self::$db == null){
            try{
                self::$db = new \PDO('mysql:host=localhost;dbname=cours', 'root', '', $config=null);
            }catch(\Exception $e){
                die('Erreur : '.$e->getMessage());
            }
        }
    }

}