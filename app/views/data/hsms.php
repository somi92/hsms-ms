view/data/hsms:
<?php 
  // require_once "../app/views/PageTemplate.php";
  require_once "../app/models/User.php";

  if(!isset($_SESSION)) {
    session_start();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
  <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf8" src="../../../public/js/script.js"></script>

  <head>
    <title>HSMS Management System</title>
  </head>

  <body>

  	<h1>Data Management</h1>

  	<?php 

  		if(isset($_SESSION['auth_user'])) {
        $user = $_SESSION['auth_user'];
        echo "Session active, logged in as ".$user->getName();
        echo "</br><a href='/HSMS-MS/public/home/index'>Pocetna</a>";
        echo '<div style="width: 70%; margin: auto; border: blue 1px solid">
            <table id="hsms" class="display compact" cellspacing="0" style="font-size: 13px; z-index: 2;">
            <tbody>';

            echo '<thead>
                    <tr>
                        
                        <th class="dt-head-left" width="3%">ID</th>

                        <th class="dt-head-left" width="25%">Opis</th>
                        
                        <th class="dt-head-left" width="4%">Broj</th>
                        
                        <th class="dt-head-left" width="10%">Cena poruke</th>
                        
                        <th class="dt-head-left" width="10%">Status</th>
                        
                        <th class="dt-head-left" width="20%">Organizacija</th>
                        
                        <th class="dt-head-left" width="10%">Website</th>
                        
                        <th class="dt-head-left" width="3%">Prioritet</th>
                        
                        <th class="dt-head-left" width="15%">Napomena</th>
                    </tr>
                  </thead>';


            $obj = $data["actions"];
            // var_dump($obj);
            // if(is_array($data)) {

            //   foreach ($obj as $k=>$v) {
                
            //     echo '
            //         <tr>
            //             <td>'.($k+1).'</td>
            //             <td>'.$v->getId().'</td>
            //             <td>'.$v->getDesc().'</td>
            //             <td>'.$v->getPrice().'</td>
            //             <td>'.$v->getStatus().'</td>
            //             <td>'.$v->getOrganisation().'</td>
            //             <td>'.$v->getWeb().'</td>
            //             <td>'.$v->getPriority().'</td>
            //             <td>'.$v->getRemark().'</td>
            //         </tr>
            //     ';

            //   }

            // } else {

            // }

        echo '</tbody>
        </table></div>';
        // $obj = $data["actions"];
        // $json = json_encode($data);
        echo '<button id="btn_insert">Dodaj novu akciju</button>';
        echo '<button id="btn_update">Izmeni</button>';
        echo '<button id="btn_delete">Obrisi</button>';
        echo '</br></br><a href="/HSMS-MS/public/home/logout">Logout</a>';
      }

  	?>

    <script type="text/javascript">
      var arr = <?php echo json_encode($data["actions"]) ?>;

    </script>

    <div id="abc">
    
      <div id="popupContact">
        <form action="" id="form" method="post" name="form">
          <img id="close" src="images/3.png" onclick ="div_hide()">
          <h2>Unesite novu humanitarnu akciju</h2>
          <hr>
          <input id="desc" name="desc" placeholder="Opis" type="text">
          <input id="number" name="number" placeholder="Broj" type="text">
          <input id="price" name="price" placeholder="Cena" type="text">
          <input id="status" name="status" placeholder="Status" type="text">
          <!-- <input id="organisation" name="organisation" placeholder="Organizacija" type="text"> -->
          <p>Organisation</p>
          
          <select id="organisation" name="organisation" placeholder="Organisation">
              
          </select>
          <p>Prioritet</p>
          <select id="priority" name="priority" placeholder="Prioritet">
              <option value="1">prvi</option>
              <option value="2">drugi</option>
              <option value="3">treci</option>
          </select>
          <input id="remark" name="remark" placeholder="Napomena" type="text">
          </br>
          </br>
          <a href="javascript:%20check_empty()" id="submit">Unesi</a>
        </form>
      </div>

    </div>

  </body>
</html>