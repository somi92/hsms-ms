view/data/index:
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

  <body>

  	<?php 

  		if(isset($_SESSION['auth_user'])) {
	        $user = $_SESSION['auth_user'];
          $pt->showHeader("Korisnik: ".$user->getName(), true);

	        echo '</br></br></br><a style="text-decoration: none; color: white;" href="/HSMS-MS/public/data/view/hsms"><button style="height: 100px; font-size: 30px;">Humanitarne akcije</button></a>';
	        echo '<a style="text-decoration: none; color: white;" href="/HSMS-MS/public/data/view/organisations"><button style="height: 100px; font-size: 30px;">Organizacije</button></a>';
          echo '<a style="text-decoration: none; color: white;" href="/HSMS-MS/public/data/view/donations"><button style="height: 100px; font-size: 30px;">Donacije</button></a>';
	        
          $pt->showFooter();

	     } else {
	      	echo '</br><p>Nemate pristup.</p>';
	      	echo '</br><a href="/HSMS-MS/public/home/index">Login</a>';
	     }

  	?>

  </body>
</html>