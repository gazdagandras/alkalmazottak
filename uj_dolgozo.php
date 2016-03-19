<?php
session_start();

require 'config.php';

$hibauzenet = '';
$uzenet = '';

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
  $nev = mysqli_real_escape_string($link, filter_input(INPUT_POST, "nev"));
  $irszam = $_POST["irszam"];
  $telepules = $_POST["telepules"];
  $cim = mysqli_real_escape_string($link, filter_input(INPUT_POST, "cim"));
  $szuletesi_hely = $_POST["szuletesi_hely"];
  $szuletesi_ido = $_POST["szuletesi_ido"];
  $szemelyig_szam = $_POST["szemelyig_szam"];

  $sql = "INSERT INTO alkalmazottak_adatai "
          . "(nev, irszam, telepules, cim, szuletesi_hely, szuletesi_ido, szemelyig_szam) "
          . "VALUES ('$nev','$irszam','$telepules','$cim','$szuletesi_hely','$szuletesi_ido','$szemelyig_szam')";
  //echo $sql;
  mysqli_query($link, $sql);
  // Hibakezelés:
  if (mysqli_errno($link)) {
    $hibauzenet = "Adatbázis hiba: " . mysqli_error($link);
  } else {
    $uzenet = "Sikeresen felvettük az új dolgozót: " . $nev;
  }
}
?><!DOCTYPE html>
<html>
    <head>
        <title>Alkalmazottak nyilvántartása - Új alkalmazott felvitele</title>
        <meta charset="utf-8">

        <script src="https://code.jquery.com/jquery-1.12.1.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="container-fluid">

            <div class="col-sm-12 col-xs-6">
                <h1>Alkalmazottak nyilvántartása</h1>
            </div>

            <?php
// Be vagyok-e lépve?
            if (isset($_SESSION["felhasznalonev"])) {
              echo '<div id="userinfo">';
              echo '  Belépve mint: ' . $_SESSION["felhasznalonev"];
              echo '  <a href="?kilepes">Kilépés</a>';
              echo '</div>';
              ?>

              <div class="col-sm-12">
                  <ul class="nav nav-pills">
                      <li><a href="index.php">Dolgozók listája</a></li>
                      <li class="active"><a href="uj_dolgozo.php">Új dolgozó</a></li>
                  </ul>
              </div>

              <div class="col-sm-12">

                  <?php
                  if ($uzenet != '') {
                    echo '<div class="alert alert-success">' . $uzenet . '</div>';
                  }
                  if ($hibauzenet != '') {
                    echo '<div class="alert alert-danger">' . $hibauzenet . '</div>';
                  }
                  ?>
                  
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

              </div>
              <?php
            }
            ?>
        </div>
    </body>
</html> 
<?php
// Adatbázis kapcsolat bezárása:
mysqli_close($link);
