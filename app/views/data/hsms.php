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
  <script type="text/javascript" charset="utf8" src="../../../public/js/session.js"></script>

  <script type="text/javascript">
      //   (function( $ ){
      //       div_org_load();
      // })( jQuery );
      $(document).ready(function() {
        $.post("/HSMS-MS/public/data/query",{
                  query_target: "ORGANIZACIJA"
                  },function(data){
                    // alert(data);
                    $.session.set("org_data",data);
                    var obj = jQuery.parseJSON(data);
                    for(var i=0; i<obj.length; i++) {
                      var node = document.createElement("OPTION");
                      node.setAttribute("value",obj[i]['id']);
                      var textnode = document.createTextNode(obj[i]['name']+"");
                      node.appendChild(textnode);
                      document.getElementById("organisation").appendChild(node);
                    } 
                  });  
      });
    </script>

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
        $json = json_encode($data);
        // var_dump($json);
        echo '<button id="popup" onclick="div_show()">Dodaj novu akciju</button>';
        echo '<button id="btn_delete">Obrisi</button>';
        echo '</br></br><a href="/HSMS-MS/public/home/logout">Logout</a>';
      }

  	?>

    <script>
      var arr = <?php echo json_encode($data["actions"]) ?>;
      function check_empty() {
      if (document.getElementById('desc').value == "" || document.getElementById('number').value == "" || document.getElementById('price').value == "") {
      alert("Morate popuniti opis, broj i cenu!");
      } else {
      // document.getElementById('form').submit();
      // alert("Form Submitted Successfully...");

      
      var descF = $("#desc").val();
      var numberF = $("#number").val();
      var priceF = $("#price").val();
      var statusF = $("#status").val();
      var organisationF = $("#organisation").val();
      var priorityF = $("#priority").val();
      var remarkF = $("#remark").val();

        $.post("/HSMS-MS/public/data/insert",{
          desc: descF,
          number: numberF,
          price: priceF,
          status: statusF,
          organisation: organisationF,
          priority: priorityF,
          remark: remarkF
        },

        function(data) {
          // alert(data);
          document.getElementById('form').submit();
          $(document).loadTable();
        });
      }
    }
//Function To Display Popup
function div_show() {
  document.getElementById('abc').style.display = "block";
  // document.getElementById('organisation').inner
}

function div_org_load() {
    // $.post("/HSMS-MS/public/data/query",{
    //               query_target: "ORGANIZACIJA"
    //               },function(data){
    //                 alert(data);
    //                 $.session.set("org_data",data);
    //               });  
}
//Function to Hide Popup
function div_hide(){
  document.getElementById('abc').style.display = "none";
}

    </script>

    <script type="text/javascript">

    var table;
    var arr = <?php echo json_encode($data["actions"]) ?>;
      $(document).ready(function() {

        $(document).loadTable();
    //       $('#hsms').DataTable({
    //         data: arr,
    //         columns: [
    //             { data: 'id' },
    //             { data: 'desc' },
    //             { data: 'number'},
    //             { data: 'price'},
    //             { data: 'status'},
    //             { data: 'organisation'},
    //             { data: 'web'},
    //             { data: 'priority'},
    //             { data: 'remark'}
    //         ],
    //         searching: false,
    //         ordering:  false,
    //         language: {
    //           "sProcessing":   "Procesiranje u toku...",
    //           "sLengthMenu":   "Prikaži _MENU_ elemenata",
    //           "sZeroRecords":  "Nije pronađen nijedan rezultat",
    //           "sInfo":         "Prikaz _START_ do _END_ od ukupno _TOTAL_ elemenata",
    //           "sInfoEmpty":    "Prikaz 0 do 0 od ukupno 0 elemenata",
    //           "sInfoFiltered": "(filtrirano od ukupno _MAX_ elemenata)",
    //           "sInfoPostFix":  "",
    //           "sSearch":       "Pretraga:",
    //           "sUrl":          "",
    //           "oPaginate": {
    //               "sFirst":    "Početna",
    //               "sPrevious": "Prethodna",
    //               "sNext":     "Sledeća",
    //               "sLast":     "Poslednja"
    // }
    //         }
    //     });

       $('#hsms tbody').on( 'click', 'tr', function () {
              if ( $(this).hasClass('selected') ) {
                  $(this).removeClass('selected');
              }
              else {
                  table.$('tr.selected').removeClass('selected');
                  $(this).addClass('selected');
              }
          } );
       
          $('#btn_delete').click( function () {
              // table.row('.selected').remove().draw( false );
              if(table.row('.selected').data() == null) {
                  alert("Izaberite red tabele koji zelite izbrisati.");
              } else {
                if(window.confirm("Jeste li sigurni?")) {
                  var id = table.row('.selected').data().id;
                  $.post("/HSMS-MS/public/data/delete",{
                    delete_table: "HUMANITARNI_BROJ",
                    delete_id: id
                },

                function(data) {
                  // alert(data);
                  // document.getElementById('form').submit();
                  // $(document).loadTable();
                  // if(data == "ok") {
                    table.row('.selected').remove().draw( false );
                    // alert("OKKKKKKK");
                  // } else {
                    // alert("ERROOOR");
                  // }
                });
                }
                // alert(table.row('.selected').data().remark);
                
              }
              
          } );
      });

      

      (function( $ ){
         $.fn.loadTable = function() {
            table = $('#hsms').DataTable({
            retrieve: true,
            data: arr,
            columns: [
                { data: 'id' },
                { data: 'desc' },
                { data: 'number'},
                { data: 'price'},
                { data: 'status'},
                { data: 'organisation'},
                { data: 'web'},
                { data: 'priority'},
                { data: 'remark'}
            ],
            searching: false,
            ordering:  false,
            language: {
              "sProcessing":   "Procesiranje u toku...",
              "sLengthMenu":   "Prikaži _MENU_ elemenata",
              "sZeroRecords":  "Nije pronađen nijedan rezultat",
              "sInfo":         "Prikaz _START_ do _END_ od ukupno _TOTAL_ elemenata",
              "sInfoEmpty":    "Prikaz 0 do 0 od ukupno 0 elemenata",
              "sInfoFiltered": "(filtrirano od ukupno _MAX_ elemenata)",
              "sInfoPostFix":  "",
              "sSearch":       "Pretraga:",
              "sUrl":          "",
              "oPaginate": {
                  "sFirst":    "Početna",
                  "sPrevious": "Prethodna",
                  "sNext":     "Sledeća",
                  "sLast":     "Poslednja"
              }
            }
        });
         }; 
      })( jQuery );
    </script>

    <script>

            // $(document).ready(function() {
                // $.post("/HSMS-MS/public/data/query",{
                //   query_target: "ORGANIZACIJA"
                //   },function(data){
                //     alert(data);
                //     $.session.set("org_data",data);
                //   });  
            // });
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