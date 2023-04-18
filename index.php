táblázat készítés php-ban. méret $sor x $oszlop<br>
<?php

$sor=3;
$oszlop=5;

print '<table border=1>';

$i = 0;
ujrai:
if ($i < $sor) {
print '<tr>';
$j = 0;
ujraj:
if ($j < $oszlop) {
print '<td>'.$i.'.sor,'.$j.'.oszlop</td>';
$j++;
goto ujraj;
}
echo '</tr>';
$i++;
goto ujrai;
}
print '</table>';
vege:
?>
