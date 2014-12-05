function check_empty() {
      
  if (document.getElementById('desc').value == "" || document.getElementById('number').value == "" || document.getElementById('price').value == "") {
    alert("Morate popuniti opis, broj i cenu!");
  } else {
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
        }
      );
    }
}

function div_show() {
  document.getElementById('abc').style.display = "block";
  $.post("/HSMS-MS/public/data/query",{
      query_target: "ORGANIZACIJA"
    },

    function(data){
      // alert(data);

      var orgNode = document.getElementById("organisation");
			while (orgNode.firstChild) {
    		orgNode.removeChild(orgNode.firstChild);
			}

      var obj = jQuery.parseJSON(data);
      for(var i=0; i<obj.length; i++) {
        var node = document.createElement("OPTION");
        node.setAttribute("value",obj[i]['id']);
        var textnode = document.createTextNode(obj[i]['name']+"");
        node.appendChild(textnode);
        document.getElementById("organisation").appendChild(node);
      } 
    });  
  // document.getElementById('organisation').inner
}

function div_org_load() {

}

function div_hide(){

	$("#desc").val("");
  $("#number").val("");
  $("#price").val("");
  $("#status").val("");
	$("#organisation").val("");
  $("#priority").val("");
	$("#remark").val("");

  document.getElementById('abc').style.display = "none";
}

var table;
$(document).ready(function() {

  $(document).loadTable();
      
  $('#hsms tbody').on( 'click', 'tr', function () {
          
    if ( $(this).hasClass('selected') ) {
      $(this).removeClass('selected');
    } else {
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
	});

	$('#btn_update').click( function() {
		if(table.row('.selected').data() == null) {
			alert("Izaberite red tabele koji zelite izmeniti.");
		} else {
				
				// alert(table.row('.selected').data().organisation);
				var id = table.row('.selected').data().id;
				var desc = table.row('.selected').data().desc;
				var number = table.row('.selected').data().number;
				var price = table.row('.selected').data().price;
				var status = table.row('.selected').data().status;
				var selectedOrganisation = table.row('.selected').data().organisation;
				var web = table.row('.selected').data().web;
				var priority = table.row('.selected').data().priority;
				var remark = table.row('.selected').data().remark;

				$("#desc").val(desc);
	      $("#number").val(number);
	      $("#price").val(price);
	      $("#status").val(status);
	      // $("#organisation").text(organisation);
	      $("#priority").val(priority);
	      $("#remark").val(remark);

	      // div_show();
	      document.getElementById('abc').style.display = "block";
	      $.post("/HSMS-MS/public/data/query",{
      query_target: "ORGANIZACIJA"
    },

    function(data){

      var orgNode = document.getElementById("organisation");
			while (orgNode.firstChild) {
    		orgNode.removeChild(orgNode.firstChild);
			}

      var obj = jQuery.parseJSON(data);
      for(var i=0; i<obj.length; i++) {
        var node = document.createElement("OPTION");
        node.setAttribute("value",obj[i]['id']);
        var textnode = document.createTextNode(obj[i]['name']+"");
        node.appendChild(textnode);
        document.getElementById("organisation").appendChild(node);
      } 

      	for(var i=0; i<orgNode.options.length; i++) {
					if(orgNode.options[i].text == selectedOrganisation) {
						orgNode.selectedIndex = i;
						break;
					}
				}
    });  

		}
	});
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
       	{ data: 'remark'}],

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