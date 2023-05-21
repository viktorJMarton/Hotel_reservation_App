<?php

class Database{
    private $db_name;
    private $user;
    private $pwd;
    private $port;
    private $host;
    static $db ;
    
  
    public function __construct() {
      $config = parse_ini_file('init/config.ini'); // Needs to be set to config_local.ini before
    
    $this->db_name = $config['dbname'];
    $this->user = $config['user'];
    $this->pwd = $config['password'];
    $this->port =$config['port'];
    $this->host =$config['host'];
    $this->connect();
      error_reporting(E_ALL);
      ini_set('display_errors', '1');
    }

    protected function  getConnectionString() {
      return $connection_string = "host={$this->host}
                                   port={$this->port} 
                                   dbname={$this->db_name} 
                                   user={$this->user} 
                                   password={$this->pwd}";
    }

    public function connect() {
   
    if (!isset(self::$db)) {
        
        try{
          self::$db= new PDO("pgsql:host={$this->host};
                        dbname={$this->db_name}",
                        $this->user,
                        $this->pwd
                        );
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
        }catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
        }
      } 

    }
  
    public function getDbName() {
      return $this->db_name;
    }

    public function getThisUser() {
      return $this->user;
    }

    public function getPwd() {
      return "A Jelszo megtekintese letiltva";
    }

    public function queryDbToJs($query_str) {
      
      $result =self::$db->query($query_str);
      $data = array();
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
      }
      $json_data = json_encode($data);
      
      return $json_data;
  }

  public function addSession($room_id, $start_time, $end_time, $screentime) {
    $sql = "INSERT INTO sessions (room_id, start_time, end_time, screentime) VALUES (:room_id, :start_time, :end_time, :screentime)";
    $stmt = self::$db->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':screentime', $screentime);
    $stmt->execute();
}

   
  }
?>
