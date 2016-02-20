<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'alkalmazottak';

// Adatbázis kapcsolat nyitása:
$link = mysqli_connect($host, $user, $password, $database);

// Hibakezelés:
if (mysqli_connect_errno()) {
  die(mysqli_connect_error());
}

// UTF-8 beállítása a kapcsolatra:
mysqli_set_charset($link, "utf8");


?><!DOCTYPE html>
<html>
    <head>
        <title>Alkalmazottak nyilvántartása</title>
        <meta charset="utf-8">
    </head>
    <body>

        <h1>Alkalmazottak nyilvántartása</h1>

        <h2>Alkalmazottak adatai</h2>

        <table border="1">
            <tr>
                <th>Név</th>
                <th>Cím</th>
                <th>Telefon</th>
                <th>e-mail</th>
                <th>Szül. hely</th>
                <th>Szül. idő</th>
            </tr>
            
            <?php
            $sql = "SELECT * FROM alkalmazottak_adatai";
            $result = mysqli_query($link, $sql);
            
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<tr>';
              echo '<td>'.$row['nev'].'</td>';
              echo '<td>'.$row['irszam'].' '.$row['telepules'].', '.$row['cim'].'</td>';
              echo '<td>'.$row['telefon'].'</td>';
              echo '<td>'.$row['email'].'</td>';
              echo '<td>'.$row['szuletesi_hely'].'</td>';
              echo '<td>'.$row['szuletesi_ido'].'</td>';
              echo '</tr>';
            }
            ?>
                        
        </table>

    </body>
</html> 
<?php

// Adatbázis kapcsolat bezárása:
mysqli_close($link);
