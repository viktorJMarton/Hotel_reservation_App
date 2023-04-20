<?php require_once 'init/db_connect.php'; ?>



<!DOCTYPE html>
<html>
  <head>
    <title>Hotel-Reservation</title>
    <link rel="stylesheet" href="layouts/styles/main.css">
	<link rel="stylesheet" href="./3rd_party/font-awesome-4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <header>
	<?php include("layouts/partials/header.html"); ?>
    </header>
	<?php include("layouts/partials/navigation.html"); ?>
    <main>
	<?php include("layouts/partials/welcome.php"); ?>
    </main>
    <footer>
      &copy; Hotel Reservation Ltd.
    </footer>
  </body>
</html>
