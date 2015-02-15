view/data/organisations:
<?php 
  require_once "../app/views/PageTemplate.php";
  require_once "../app/models/User.php";

  $pt  = new PageTemplate();

  if(!isset($_SESSION)) {
    session_start();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="utf-8">

  	<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../../public/res/DataTables-1.10.4/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../public/res/DataTables-1.10.4/media/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="../../../public/res/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <script type="text/javascript" charset="utf8" src="../../../public/js/org_script.js"></script>

  <head>
    <title>HSMS Management System</title>
  </head>

  <body>

  	<?php 

  		if(isset($_SESSION['auth_user'])) {

        $user = $_SESSION['auth_user'];
        $pt->showHeader("Korisnik: ".$user->getName());

        $message = "";	
        if($user->getRole() != "admin") {
        	$message = " (nemate privilegije za menjanje)";
        }

        echo '<div id="content">

        <h2 id="module_title">Pregled povezanih organizacija'.$message.'</h2>

        <div id="table_container" style="width: 95%; margin: auto; border: blue 0px solid">

            <table id="orgs" class="display compact" cellspacing="0" style="font-size: 15px; z-index: 2;">
            <tbody>';

            echo '<thead>
                    <tr>
                        
                        <th class="dt-head-left" width="3%">ID</th>
                        <th class="dt-head-left" width="20%">Naziv</th>
                        <th class="dt-head-left" width="25%">Opis</th>
                        <th class="dt-head-left" width="10%">Website</th>
                    </tr>
                  </thead>';

        echo '</tbody>
        </table></div>';

        if($user->getRole() == "admin") {
        	echo '<div id="button_panel"><button id="btn_insert">Dodaj organizaciju</button>';
        	echo '<button id="btn_update">Izmeni</button>';
        	echo '<button id="btn_delete">Obrisi</button></div>';
        }
        echo '</div>';
        $pt->showFooter();

      } else {
          $pt->showHeader();
      }
  	?>

  	<script type="text/javascript">
      var arr = <?php echo $data; ?>;
    </script>

    <div id="abc">
    
      <div id="popupContact">
        <form action="" id="form" method="post" name="form">
          <img id="close" src="../../../app/views/res/close.png" height="48" width="48" onclick ="div_hide()">
          <h2>Unesite organizaciju</h2>
          <hr>
          <input id="name" class="form_input_text" name="name" placeholder="Naziv" type="text">
          <input id="desc" class="form_input_text" name="desc" placeholder="Opis" type="text">
          <input id="web" class="form_input_text" name="web" placeholder="Website" type="text">
          </br>
          </br>
          <a href="javascript:%20check_empty()" id="submit">Unesi</a>
        </form>
      </div>

    </div>

  </body>

</html>