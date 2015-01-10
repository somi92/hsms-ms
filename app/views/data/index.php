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
  <head>
    <title>HSMS Management System</title>
  </head>

  <body>

  	<h1>Data Management</h1>
  	
  	<?php 

  		if(isset($_SESSION['auth_user'])) {
	        $user = $_SESSION['auth_user'];
	        echo "Session active, logged in as ".$user->getName();

	        echo '</br></br></br><a href="/HSMS-MS/public/data/view/hsms">Humanitarne akcije</a>';
	        echo '</br><a href="/HSMS-MS/public/data/view/donations">Donacije</a>';
	        echo '</br><a href="/HSMS-MS/public/data/view/users">Upravljanje korisnicima</a>';

	        echo '</br></br><a href="/HSMS-MS/public/home/logout">Logout</a>';
	     } else {
	      	echo '</br><p>Nemate pristup.</p>';
	      	echo '</br><a href="/HSMS-MS/public/home/index">Login</a>';
	     }

  	?>

  </body>
</html>