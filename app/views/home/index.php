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
  <head>
    <title>HSMS Management System</title>
  </head>

  <body onload="document.forms[0].reset();">

  	<h1>Dobrodosli</h1>
  	
    <?php

      if(isset($_SESSION['auth_user'])) {
        $user = $_SESSION['auth_user'];
        echo "Session active, logged in as ".$user->getName();
        $pt->showManagementPanel();
        echo '</br></br><a href="/HSMS-MS/public/home/logout">Logout</a>';
      } else {
        if($data == "logging") {
          $data = "Loggin unsuccessful, user not found.";
        }
        echo $data;
        $pt->showLoginForm();
      }
    ?>

  </body>
</html>