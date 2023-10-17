<?php
session_start();
//----------------------------------------------------------------------------
//--------            SOFTWARE DEVELOPED BY PHUONG ANH NGO        ------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------
//                          LOGOUT
//----------------------------------------------------------------
if(isset($_GET['logout']))
{  
  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"],
          $params["domain"], $params["secure"], $params["httponly"]
      );
  }
  session_destroy();
}


//----------------------------------------------------------------
//                          LOGIN
//----------------------------------------------------------------
$fehlermeldung = "";
//var_dump($_POST);
if( isset($_POST['benutzer']) && isset($_POST['passwort']) )
{

  $benutzer = trim($_POST['benutzer']);
  $passwort = trim($_POST['passwort']);

  //Eingabeüberprüfung
  if($benutzer == "")
    $fehlermeldung .= "Bitte geben Sie einen Benutzernamen ein!<br>";

  if($passwort == "")
      $fehlermeldung .= "Bitte geben Sie ein Passwort ein!";


  //Beide Felder ausgefüllt
  if($fehlermeldung == "")
  {
    //HTML-Injection verhindern
    $benutzer = htmlspecialchars($benutzer);
    $passwort_md5 = md5($passwort);

    //1. Datenbankverbindung aufbauen
    require("db_connect.php");

    //SQL-Injection verhindern
    $benutzer = mysqli_real_escape_string($connect, $benutzer);

    //2. SQL-Statement ausführen
    $sql = "SELECT id, type
            FROM users
            WHERE username = '$benutzer'
            AND password = '$passwort_md5'";
    $resultset = mysqli_query($connect, $sql);

    if(!$resultset)   //SQL-Fehler ausgeben
      die("<p style=\"color:red\">" . mysqli_error($connect) . "</p>");

    $anzahl = mysqli_num_rows($resultset);

    if($anzahl < 1)
      $fehlermeldung .= "Benutzername oder Passwort falsch!";
    else {
      // 3. Abfrageergebnis verarbeiten
      $row = mysqli_fetch_assoc($resultset);
      $benutzer_id = $row['id'];
      $type = $row['type'];

      //benutzer_id in Session-Variable speichern
      $_SESSION['benutzer_id'] = $benutzer_id;
      $_SESSION['benutzer'] = $benutzer;
      $_SESSION['type'] = $type;
      //var_dump($_SESSION);
      header("Location:home.php");
    }
  }
}

    include("partials/header.php");
   //wenn nicht leer bzw. Fehler aufgetreten ist
    if(!empty($fehlermeldung))
      echo "<p style=\"color:red\">$fehlermeldung</p>";
   ?>
<!-- //////////    Login Panel   //////////// -->
<div id="container-login">
  <h1>Login</h1><br><br>
    <div class="row ">
      <div class="col-md-7 col-lg-8">
        <form action="login.php" method="post" class="needs-validation" novalidate="">
          <div class="row g-3">  
            <div class="col-12">
              <label for="username" class="form-label">Username</label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" id="username" name="benutzer" placeholder="Username" required="" name="benutzer">
              </div>
            </div>
          </div>
          <hr>
          <div class="row gy-3">
            <div class="col-12">
              <label for="cc-name" class="form-label">Passwort</label>
              <input type="password" class="form-control" name="passwort" id="cc-name" placeholder="" required="" name="passwort1">
            </div>
          </div>
          <hr class="my-4">
          <button class="w-100 btn btn-primary btn-lg" type="submit" value="Registrieren">Login</button>
        </form>
      </div>
    </div>
    </div>

<!-- /////////////////////////////////////////////////////// -->
  <?php
    include("partials/footer.php");
  ?>
