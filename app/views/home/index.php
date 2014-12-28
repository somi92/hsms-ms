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
        // echo "Session active, logged in as ".$user->getName();
        $pt->showHeader("Sesija aktivna, prijavljeni ste kao ".$user->getName());
        $pt->showManagementPanel();
        // echo '</br></br><a href="/HSMS-MS/public/home/logout">Logout</a>';
        $pt->showFooter();
      } else {
        echo '<h3 id="welcome">Dobrodošli - HSMS Management system</h3>';
        if($data == "logging") {
          $data = "Prijava je neuspešna, korisnik nije pronađen.";
          echo $data;
        }
        echo '<div id="login_form">';
        $pt->showLoginForm();
        echo '</div>';
      }
    ?>

  </body>
</html>