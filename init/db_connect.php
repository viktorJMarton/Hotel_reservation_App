<?php
<<<<<<< Updated upstream
require 'models/Database.php';
=======
require_once 'models/Database.php';
>>>>>>> Stashed changes

// Define the database connection parameters
// Check if the database connection has already been established
if (!isset($db)) {
    // If not, create a new Database object and connect to the database
    $db = new Database();
    $db->connect();
    
}

?>
