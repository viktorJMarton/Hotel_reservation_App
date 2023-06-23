<?php
require '../init/db_connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $email = $_POST['email'];
   $pwd = $_POST['pwd'];

   $stmt = $db->UserIsRegistered($email, $pwd);
   $result = $stmt->fetchColumn();
   
   if ($result) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header('Location: ../index.php');
        exit();
   }
}
header('Location: ../login.html');
exit();
?>
