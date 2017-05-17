<?php
class Db {
    private static $instance = NULL;
    private static $instance2 = NULL;
    private static $instance3 = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance($config = array('host'=>DB_SERVER,'db_name'=>DB_DATABASE,'db_username'=>DB_USERNAME,'db_password'=>DB_PASSWORD)) {
      if (!isset(self::$instance)) {
        //$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['db_name'], $config['db_username'], $config['db_password']);
        self::$instance->exec("SET CHARACTER SET utf8");
      }
    }
    public static function dbConnection(){
      return self::$instance;
    }

    public static function getInstance2($config = array('host'=>DB_SERVER_2,'db_name'=>DB_DATABASE_2,'db_username'=>DB_USERNAME_2,'db_password'=>DB_PASSWORD_2)) {
      if (!isset(self::$instance2)) {
        //$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance2 = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['db_name'], $config['db_username'], $config['db_password']);
        self::$instance2->exec("SET CHARACTER SET utf8");
      }
    }
    public static function dbConnection2(){
      return self::$instance2;
    }

    public static function getInstance3($config = array('host'=>DB_SERVER_3,'db_name'=>DB_DATABASE_3,'db_username'=>DB_USERNAME_3,'db_password'=>DB_PASSWORD_3)) {
      if (!isset(self::$instance3)) {
        //$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance3 = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['db_name'], $config['db_username'], $config['db_password']);
        self::$instance3->exec("SET CHARACTER SET utf8");
      }
    }
    public static function dbConnection3(){
      return self::$instance3;
    }

} 