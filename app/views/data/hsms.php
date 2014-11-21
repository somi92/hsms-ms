view/data/hsms:
<!DOCTYPE html>
<html lang="en">
  
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
  
  <head>
    <title>HSMS Management System</title>
  </head>

  <body>

  	<h1>Data Management</h1>
  	
  	<?php 

  		if(isset($_SESSION['auth_user'])) {
        $user = $_SESSION['auth_user'];
        echo "Session active, logged in as ".$user->getName();

        

        echo '</br></br><a href="/HSMS-MS/public/home/logout">Logout</a>';
      }

  	?>

  </body>
</html>