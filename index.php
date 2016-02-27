<?php

session_start();

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

// Dolgozó törlése:
if (isset($_POST["dolgozo_torlese"])) {
  $szemelyig_szam = $_POST["szemelyig_szam"];
  $sql = "DELETE FROM alkalmazottak_adatai WHERE szemelyig_szam='$szemelyig_szam'";
  mysqli_query($link, $sql);
}

// Belépés
if (isset($_POST["belepes"])) {
  $felhasznalonev = $_POST["felhasznalonev"];
  $jelszo = $_POST["jelszo"];
  
  // "Buta" módszer:
  if ($felhasznalonev == "admin" && $jelszo == "12345") {
    $_SESSION["felhasznalonev"] = $felhasznalonev;
  }
}

// Kilépés
if (isset($_GET["kilepes"])) {
  unset($_SESSION["felhasznalonev"]);
  session_destroy();
}

?><!DOCTYPE html>
<html>
    <head>
        <title>Alkalmazottak nyilvántartása</title>
        <meta charset="utf-8">
    </head>
    <body>

        <h1>Alkalmazottak nyilvántartása</h1>

        <?php
        // Be vagyok-e lépve?
        if (isset($_SESSION["felhasznalonev"])) {
          echo '<div id="userinfo">';
          echo '  Belépve mint: ' . $_SESSION["felhasznalonev"];
          echo '  <a href="?kilepes">Kilépés</a>';
          echo '</div>';
        ?>
        
        <h2>Alkalmazottak adatai</h2>

        <table border="1">
            <tr>
                <th>Név</th>
                <th>Cím</th>
                <th>Telefon</th>
                <th>e-mail</th>
                <th>Szül. hely</th>
                <th>Szül. idő</th>
                <th>Admin</th>
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
              // Törlés link A elemmel:
              //echo '<td><a href="?torol='.$row["szemelyig_szam"].'">törlés</a></td>';
              // Törlés gomb űrlappal:
              echo '<td>';
              echo '<form method="post">';
              echo '<input type="hidden" name="szemelyig_szam" value="'.$row["szemelyig_szam"].'">';
              echo '<input type="submit" value="Törlés" name="dolgozo_torlese">';
              echo '</form>';
              echo '</td>';
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

        <?php
        
        } // if
        else {
        
        ?>
        
        <h2>Belépés</h2>
        
        <form method="post">
            <label>Felhasználónév:</label>
            <input type="text" name="felhasznalonev">
            <br>
            <label>Jelszó:</label>
            <input type="password" name="jelszo">
            <br>
            <input type="submit" name="belepes" value="Belépés">
        </form>
        
        <?php
        
        }
        
        ?>
        
    </body>
</html> 
<?php

// Adatbázis kapcsolat bezárása:
mysqli_close($link);
