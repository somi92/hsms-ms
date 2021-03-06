view/data/hsms:
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
  <!--<link rel="stylesheet" type="text/css" href="../../../public/res/DataTables-1.10.4/media/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
  <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="../../../public/res/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" charset="utf8" src="../../../public/js/hsms_script.js"></script>
-->
    <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../../public/res/DataTables-1.10.4/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../public/res/DataTables-1.10.4/media/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="../../../public/res/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
    <!--<script src="../../../public/res/DataTables-1.10.4/extensions/Plugins/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="../../../public/res/DataTables-1.10.4/extensions/Plugins/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../../../public/res/bs/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/res/bs/css/bootstrap-theme.min.css">
    <script src="../../../public/res/bs/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">

    <script type="text/javascript" charset="utf8" src="../../../public/js/hsms_script.js"></script>

  <head>
    <title>HSMS Management System</title>
  </head>

  <body>

  	<?php 

      $message = "";

  		if(isset($_SESSION['auth_user'])) {

        $user = $_SESSION['auth_user'];
        $pt->showHeader("Korisnik: ".$user->getName());
        
        if($user->getRole() != "admin") {
          $message = " (nemate privilegije za brisanje)";
        }
      } else {
        $pt->showHeader();
      }  
        echo '<div id="content">

        <h2 id="module_title">Pregled humanitarnih akcija'.$message.'</h2>';
      
      if(isset($_SESSION['auth_user'])) {

        echo '<div id="rt_search">
          <form id="search_form">

            <p>Pretraga povezanih organizacija:</p>
            <input id="search_key" name="search_key" placeholder="Unesite naziv organizacije" type="text">

          </form>
          <div id="search_live"></div>

        </div>';
      }

        echo '<div id="table_container" style="width: 95%; margin: auto; border: blue 0px solid">

            <table id="hsms" class="display compact" cellspacing="0" style="font-size: 15px; z-index: 2;">
            <tbody>';

            echo '<thead>
                    <tr>
                        
                        <th class="dt-head-left" width="3%">ID</th>

                        <th class="dt-head-left" width="40%">Opis</th>
                        
                        <th class="dt-head-left" width="4%">Broj</th>
                        
                        <th class="dt-head-left" width="10%">Cena poruke</th>
                        
                        <th class="dt-head-left" width="10%">Status</th>
                        
                        <th class="dt-head-left" width="20%">Organizacija</th>
                        
                        <th class="dt-head-left" width="10%">Website</th>
                        
                        <th class="dt-head-left" width="3%">Prioritet</th>
                        
                        <!-- <th class="dt-head-left" width="15%">Napomena</th> -->
                    </tr>
                  </thead>';


          

        echo '</tbody>
        </table></div>';
        
        if(isset($_SESSION['auth_user'])) {

          $user = $_SESSION['auth_user'];
          echo '<div id="button_panel"><button id="btn_insert">Dodaj novu akciju</button>';
          echo '<button id="btn_update">Izmeni</button>';
          if($user->getRole() == "admin") {
            echo '<button id="btn_delete">Obrisi</button></div>';
          } else {
            echo '</div>';
          }
      }
      echo '</div>';
      $pt->showFooter();

  	?>

    <script type="text/javascript">
      var arr = <?php echo json_encode($data["actions"]); ?>;
    </script>

    <div id="abc">
    
      <div id="popupContact">
        <form action="" id="form" method="post" name="form">
          <img id="close" src="../../../app/views/res/close.png" height="48" width="48" onclick ="div_hide()">
          <h2>Unesite novu humanitarnu akciju</h2>
          <hr>
          <input id="desc" class="form_input_text" name="desc" placeholder="Opis" type="text">
          <input id="number" class="form_input_text" name="number" placeholder="Broj" type="text">
          <input id="price" class="form_input_text" name="price" placeholder="Cena" type="text">
          <input id="status" class="form_input_text" name="status" placeholder="Status" type="text">
          <!-- <input id="organisation" name="organisation" placeholder="Organizacija" type="text"> -->
          <p>Organizacija</p>
          
          <select id="organisation" name="organisation" placeholder="Organisation">
              
          </select>
          <p>Prioritet</p>
          <select id="priority" name="priority" placeholder="Prioritet">
              <option value="1">prvi</option>
              <option value="2">drugi</option>
              <option value="3">treci</option>
          </select>
          <textarea id="remark" class="form_input_text" name="remark" placeholder="Napomena" type="text"></textarea>
          </br>
          </br>
          <a href="javascript:%20check_empty()" id="submit">Unesi</a>
        </form>
      </div>

    </div>

  </body>
</html>