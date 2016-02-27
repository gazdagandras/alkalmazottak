<?php
session_start();

require 'config.php';

$hibauzenet = '';

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
          . "(nev, irszam, telepules, cim, szuletesi_hely, szuletesi_ido, szemelyig_szam) "
          . "VALUES ('$nev','$irszam','$telepules','$cim','$szuletesi_hely','$szuletesi_ido','$szemelyig_szam')";
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

  $kodolt_jelszo = md5($jelszo);

  $sql = "SELECT * FROM felhasznalok WHERE felhasznalonev='$felhasznalonev' AND jelszo='$kodolt_jelszo'";
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) == 1) {
    $_SESSION["felhasznalonev"] = $felhasznalonev;
  } else {
    $hibauzenet = "Rossz név vagy jelszó!";
  }
}

// Kilépés
if (isset($_GET["kilepes"])) {
  unset($_SESSION["felhasznalonev"]);
  session_destroy();
  header('Location: ' . $baseUrl);
}
?><!DOCTYPE html>
<html>
    <head>
        <title>Alkalmazottak nyilvántartása</title>
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

            <div class="col-sm-12">
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
                  <h2>Alkalmazottak adatai</h2>

                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Név</th>
                              <th>Cím</th>
                              <th>Telefon</th>
                              <th>e-mail</th>
                              <th>Szül. hely</th>
                              <th>Szül. idő</th>
                              <th>Admin</th>
                          </tr>
                      </thead>

                      <tbody>
                          <?php
                          $sql = "SELECT * FROM alkalmazottak_adatai";
                          $result = mysqli_query($link, $sql);

                          while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['nev'] . '</td>';
                            echo '<td>' . $row['irszam'] . ' ' . $row['telepules'] . ', ' . $row['cim'] . '</td>';
                            echo '<td>' . $row['telefon'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['szuletesi_hely'] . '</td>';
                            echo '<td>' . $row['szuletesi_ido'] . '</td>';
                            // Törlés link A elemmel:
                            //echo '<td><a href="?torol='.$row["szemelyig_szam"].'">törlés</a></td>';
                            // Törlés gomb űrlappal:
                            echo '<td>';
                            echo '<form method="post">';
                            echo '<input type="hidden" name="szemelyig_szam" value="' . $row["szemelyig_szam"] . '">';
                            echo '<input type="submit" value="Törlés" name="dolgozo_torlese">';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                          }
                          ?>
                      </tbody>
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

              </div>
              <?php
            } // if
            else {
              ?>

              <div class="col-sm-12">
                  <?php
                  if ($hibauzenet != '') {
                    echo '<div class="alert alert-danger">';
                    echo $hibauzenet;
                    echo '</div>';
                  }
                  ?>
              </div>

              <div class="col-sm-6 col-sm-offset-3">
                  <h2>Belépés</h2>

                  <form method="post">
                      <div class="form-group">                      
                          <label>Felhasználónév:</label>
                          <input type="text" name="felhasznalonev" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>Jelszó:</label>
                          <input type="password" name="jelszo" class="form-control">
                      </div>
                      <div class="form-group">
                          <input type="submit" name="belepes" value="Belépés" class="btn">
                      </div>
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
