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

// Új dolgozó felvitele:
if (isset($_POST["uj_dolgozo"])) {
  $nev = $_POST["nev"];
  $irszam = $_POST["irszam"];
  $telepules = $_POST["telepules"];
  $cim = $_POST["cim"];
  $szuletesi_hely = $_POST["szuletesi_hely"];
  $szuletesi_ido = $_POST["szuletesi_ido"];
  $szemelyig_szam = $_POST["szemelyig_szam"];
  
  $sql = "INSERT INTO alkalmazottak_adatai "
          ."(nev, irszam, telepules, cim, szuletesi_hely, szuletesi_ido, szemelyig_szam) "
          ."VALUES ('$nev','$irszam','$telepules','$cim','$szuletesi_hely','$szuletesi_ido','$szemelyig_szam')";
  //echo $sql;
  mysqli_query($link, $sql);
  // Hibakezelés:
  if (mysqli_errno($link)) {
    echo mysqli_error($link);
  }
}

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
        
        <h2>Új dolgozó adatai:</h2>
        <form method="post">
            <label>Dolgozó neve:</label>
            <input type="text" name="nev">
            <br>
            <label>Irányítószám:</label>
            <input type="text" name="irszam">
            <br>
            <label>Település:</label>
            <input type="text" name="telepules">
            <br>            
            <label>Cím:</label>
            <input type="text" name="cim">
            <br>            
            <label>Születési hely:</label>
            <input type="text" name="szuletesi_hely">
            <br>            
            <label>Születési idő:</label>
            <input type="text" name="szuletesi_ido">
            <br>            
            <label>Személyi igazolvány száma:</label>
            <input type="text" name="szemelyig_szam">
            <br>            
            <input type="submit" name="uj_dolgozo">
        </form>

    </body>
</html> 
<?php

// Adatbázis kapcsolat bezárása:
mysqli_close($link);
