<?php

class Database{
    private $db_name;
    private $user;
    private $pwd;
    private $port;
    private $host;
    private static $db;
    
  
    public function __construct() {
      $config = parse_ini_file('init/config.ini');
    
    $this->db_name = $config['dbname'];
    $this->user = $config['user'];
    $this->pwd = $config['password'];
    $this->port =$config['port'];
    $this->host =$config['host'];

      error_reporting(E_ALL);
      ini_set('display_errors', '1');
    }

    public function connect() {
        $db = pg_connect($this->getConnectionString()) 
                or die('Belépés nem sikerült. Hiba: ' . pg_last_error());

    }
  
    public function getDbName() {
      return $this->db_name;
    }

    public function getUser() {
      return $this->user;
    }

    public function getPwd() {
      return "A Jelszo megtekintese letiltva";
    }
  
    protected function  getConnectionString() {
        return $connection_string = "host={$this->host}
                                     port={$this->port} 
                                     dbname={$this->db_name} 
                                     user={$this->user} 
                                     password={$this->pwd}";
    }
  }
?>
