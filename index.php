<?php include 'init/db_connect.php'; ?>
<?php include 'init/auth.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel-Reservation</title>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" href="layouts/styles/main.css">
    <link rel="stylesheet" href="./3rd_party/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="../3rd_party/jquerry_seat_chart/jquery.seat-charts.js"></script>
</head>
<body>
<?php if (isLoggedIn()) : ?>
    <?php include("layouts/partials/_navigation.php");
 ?>
    <main id="main-content">
        <?php
            if (isset($_GET['reservations'])) {
              include("layouts/partials/_reservations.php");
          } else {
              include("layouts/partials/_main.php");
          }
        ?>
    <?php else : ?>
      <?php header("Location: login.html"); ?>
    <?php endif; ?>
    </main>
    <footer>
        &copy; Movie Ticket Ltd.
    </footer>

    
</body>
</html>
