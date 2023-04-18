<?php

class DatabaseConfig {
    private $error_reporting;
    private $db;
    private $user;
    private $pwd;
    private $port;
    private $host;
  
    public function __construct($error_reporting, $db, $user, $pwd, $port, $host) {
      $this->error_reporting = $error_reporting;
      $this->db = $db;
      $this->user = $user;
      $this->pwd = $pwd;
      $this->port = $port;
      $this->host = $host;

      error_reporting($this->error_reporting);
      ini_set('display_errors', '1');
    }
  
    public function getDb() {
      return $this->db;
    }

    public function getUser() {
      return $this->user;
    }

    public function getPwd() {
      return $this->pwd;
    }

    public function getPort() {
      return $this->port;
    }
    
    public function getHost() {
      return $this->host;
    }
  }
  
?>
