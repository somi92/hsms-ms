view/data/stats:
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
  <head>
    <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <link rel="stylesheet" type="text/css" href="../../../public/css/graph_style.css">

    <script type="text/javascript">
    
      google.load('visualization', '1.0', {'packages':['corechart']});

      var chart;
      var data;
      var flag;

      function drawGraph(obj, column, title) {

        data = new google.visualization.DataTable();
        donation_sum = 0;
        data.addColumn('string', column);
        data.addColumn('number', 'Broj donacija');
        if(column == "Humanitarna akcija") {
          flag = 0;
          data.addColumn('string', 'SMS broj');
          for (var i = 0; i < obj.stats.length; i++) {
            donation_sum += parseInt(obj.stats[i].count);
            data.addRow([obj.stats[i].desc, parseInt(obj.stats[i].count), obj.stats[i].num]);
          };
        } else {
          flag = 1;
          data.addColumn('string', 'Email');
          for (var i = 0; i < obj.stats.length; i++) {
            donation_sum += parseInt(obj.stats[i].count);
            data.addRow([obj.stats[i].desc, parseInt(obj.stats[i].count), obj.stats[i].id]);
          };
        }
        

        var options = {'title': title+"\n- suma donacija u top 10 listi: "+donation_sum,
        'is3D':false,
        'width':1000,
        'height':600};

        chart = new google.visualization.PieChart(document.getElementById('graph_container'));
      
        google.visualization.events.addListener(chart, 'select', info);

        chart.draw(data, options);
      }

    function info() {
      var selectedItem = chart.getSelection()[0];
      if (selectedItem) {
        var dataType = data.getValue(selectedItem.row, 0);
        var count = data.getValue(selectedItem.row, 1);
        var inf = data.getValue(selectedItem.row, 2);
        if(flag == 0) {
          alert("SMS broja za " + dataType + " je: " + inf);
        } else {
          alert("Email donatora " + dataType + ": " + inf);
        }
      }
    }
    </script>

    <title>HSMS Management System</title>
  </head>

  <body>

  	<?php 

      if(isset($_SESSION['auth_user'])) {

        $user = $_SESSION['auth_user'];
        $pt->showHeader("Korisnik: ".$user->getName());
      } else {
        $pt->showHeader();
      }
    ?>
      <div id="content">

        <h2 id="module_title">Statistika humanitarnih akcija</h2>
        </br>
        </br>
        <div id="panel">
          <div id="graph_container"></div>
          
          <div id="graph_buttons">
            <button id="btn1" class="buttons">Humanitarne akcije</button>
            <button id="btn2" class="buttons">Donatori</button>
          </div>
        </div>

        <script type="text/javascript">

          $(document).ready(function() {
            $.get("http://mywebprojects.com/HSMS-MS/public/service/donationstats/target:hsms", {

            }, function(res){
              drawGraph(res, "Humanitarna akcija", "Raspodela donacija za top 10 humanitarnih akcija (kliknite za vise detalja)");
            });
            
          });

          $('#btn1').click(function() {
            $.get("http://mywebprojects.com/HSMS-MS/public/service/donationstats/target:hsms", {

            }, function(res){
              drawGraph(res, "Humanitarna akcija", "Raspodela donacija za top 10 humanitarnih akcija (kliknite za vise detalja)");
            });
          });

          $('#btn2').click(function() {

            $.get("http://mywebprojects.com/HSMS-MS/public/service/donationstats/target:donators", {

            }, function(res){
              drawGraph(res, "Donator", "Raspodela donacija za top 10 donatora (kliknite za vise detalja)");
            });
          });

        </script>
        
      </div>
    
    <?php  
      $pt->showFooter();
  	?>

  </body>
</html>