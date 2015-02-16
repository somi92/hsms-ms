view/home/index: 
<?php 
  require_once "../app/views/PageTemplate.php";
  require_once "../app/models/User.php";
  if(!isset($_SESSION)) {
    session_start();
  }
  $pt = new PageTemplate();
?>
<!DOCTYPE html>
<html lang="en">
  
  <meta charset="utf-8">
  <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

  <?php
    $uri = $_SERVER['REQUEST_URI'];
    // echo $uri;
    $css_link = "";
    for($i=0; $i<(substr_count($uri, '/')-3); ++$i) {
      $css_link = $css_link."../";
      // echo $css_link." ";
    }
    // echo $css_link;
    echo '<link rel="stylesheet" type="text/css" href="'.$css_link.'css/style.css">';
  ?>

  <head>
    <title>HSMS Management System</title>
  </head>

  <body onload="document.forms[0].reset();">
  	
    <?php

      if(isset($_SESSION['auth_user'])) {
        $user = $_SESSION['auth_user'];
        $pt->showHeader("Korisnik: ".$user->getName(), true);
        $pt->showManagementPanel();
        $pt->showFooter();
      } else {
        if($data != "") {
          $pt->showHeader("", false);
        } else {
          $pt->showHeader("", true);
        }
        
        if($data == "logging") {
          echo '<h3 id="welcome">Unesite vaše korisničke podatke</h3>';
          $data = "Prijava je neuspešna, korisnik nije pronađen. Pokušajte ponovo.";
          echo '<p style="margin-left: 37%;">'.$data.'</p>';

          echo '<div id="login_form">';
          $pt->showLoginForm();
          echo '</div>';
        }
        if($data == "admin") {
          echo '<h3 id="welcome">Unesite vaše korisničke podatke</h3>';
          echo '<div id="login_form">';
          $pt->showLoginForm();
          echo '</div>';
        }

        $pt->showFooter();
      }
    ?>

  </body>
</html>