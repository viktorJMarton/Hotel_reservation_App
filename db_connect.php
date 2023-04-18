<h1>belépés az adatbázisba</h1>
az első sor csak a hibaüzenet láthatóságáról gondoskodik<br>
<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
$db = pg_connect("host=localhost port=5432 dbname=hotel_postgres_development user=postgres password=MiniMoris ") or die('Belépés nem sikerült. Hiba: ' . pg_last_error());;
echo 'Kapcsolódás sikeres.';
echo "<h1>Kapcsolati Informaciok</h1>\n";
echo 'Adatbázis neve: ' . pg_dbname($db) . "<br />\n";
echo 'Gép neve: ' . pg_host($db) . "<br />\n";
echo 'Port: ' . pg_port($db) . "<br />\n";

pg_close($db);

?>
