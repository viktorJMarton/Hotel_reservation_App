<?php

class Database{
    private $db_name;
    private $user;
    private $pwd;
    private $port;
    private $host;
    static $db ;
    
  
    public function __construct() {
      $config = parse_ini_file( __DIR__ . '/../init/config.ini'); // Needs to be set to config_local.ini before
    
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

    public function query($query_str) {
      if (!isset(self::$db)){
        $this->connect();
      }
      try {
        $result = self::$db->query($query_str);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

    }

    public function prepare($query_str) {
      if (!isset(self::$db)){
        $this->connect();
      }
      try {
        $stmt = self::$db->prepare($query_str);
        return $stmt;
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }

  public function addScreening($room_id, $start_time, $end_time, $screentime) {
    if (!isset(self::$db)) {
      $this->connect();
  }
    $sql = "INSERT INTO sessions (room_id, start_time, end_time, screentime) VALUES (:room_id, :start_time, :end_time, :screentime)";
    $stmt = self::$db->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':screentime', $screentime);
    $stmt->execute();
}

  public function getSeatMapOfScreening($scr_id){
    $statement = self::$db->query("SELECT public.get_seat_map($scr_id)");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $seat_map_json = $result['get_seat_map'];
    $seat_map_array = array_values(json_decode($seat_map_json, true));

    $seat_map_array2 = array_map(function ($row) {
      return preg_replace('/\d+/', '', $row);
  }, $seat_map_array);
  
  return $seat_map_array2;
  }

  public function getPriceOfScreening($scr_id){
    $statement = self::$db->query("SELECT public.get_price($scr_id)");
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['get_price'];
}

// Where does this function goes ?
  public function getScreeningsByTime($date){
    $date = '2023-06-20'; // A keresett dátum
    $stmt = self::$db->prepare("SELECT public.get_screenings_by_date(:dateParam)");
    $stmt->bindParam(':dateParam', $date);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $screeningIds = $result['get_screenings_by_date'];
    
    // Távolítsuk el a '{' és '}' karaktereket
    $screeningIds = str_replace(['{', '}'], '', $screeningIds);
    
    // Szétszedjük a számokat a vessző mentén
    $screeningIdArray = explode(',', $screeningIds);
    
    // Távolítsuk el a felesleges szóközöket
    $screeningIdArray = array_map('trim', $screeningIdArray);

    return $screeningIdArray;
}

   
  public function saveReservation($seatIds, $screeningId, $seatMap) {
    if (!isset(self::$db)) {
      $this->connect();
    }
      
    try {// Convert arrays to strings
      $seatIdsString = implode(',', $seatIds);
      $seatMapString = json_encode($seatMap);
      
      // Prepare and bind parameters
      $stmt = self::$db->prepare("SELECT public.save_reservation(:seatIds, :screeningId, :seatMap)");
      $stmt->bindParam(':seatIds', $seatIdsString);
      $stmt->bindParam(':screeningId', $screeningId);
      $stmt->bindParam(':seatMap', $seatMapString);
      
  
      // Execute statement
      $stmt->execute();

    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      return $e->getMessage;
    }
  }
  

  }
?>
