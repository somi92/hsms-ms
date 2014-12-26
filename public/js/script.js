var table;

function check_empty(action, update_id) {
    var target = "";
    if(action=="insert") {
      target = "/HSMS-MS/public/data/insert";
    }
    if(action=="update") {
      target = "/HSMS-MS/public/data/update";
    }
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

        $.post(target,{
            id: update_id, 
            desc: descF,
            number: numberF,
            price: priceF,
            status: statusF,
            organisation: organisationF,
            priority: priorityF,
            remark: remarkF
          },

          function(data) {
            div_hide();
            table.fnDestroy();
            var json_data = jQuery.parseJSON(data);
            loadTable(json_data);
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

  function loadTable(json_data) {

    table = $('#hsms').dataTable({
      retrieve: true,
      "data": json_data,
      "columns": [
        { "data": "id" },
        { "data": "desc" },
        { "data": "number"},
        { "data": "price"},
        { "data": "status"},
        { "data": "organisation"},
        { "data": "web"},
        { "data": "priority"},
        { "data": "remark"}],

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
  }

$(document).ready(function() {

  loadTable(arr);
      
  $('#hsms tbody').on( 'click', 'tr', function () {
          
    if ( $(this).hasClass('selected') ) {
      $(this).removeClass('selected');
    } else {
      	table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
  } );
  
  $('#btn_insert').click(function() {
  	div_show();
  	var btn_submit = document.getElementById('submit');
  	btn_submit.setAttribute('href','javascript:%20check_empty(\'insert\')');
  	btn_submit.innerHTML = "UNESI";
  });

  $('#btn_delete').click( function() {
    if(table.api().row('.selected').data() == null) {
      alert("Izaberite red tabele koji zelite izbrisati.");
    } else {
        if(window.confirm("Jeste li sigurni?")) {
          var id = table.api().row('.selected').data().id;
          $.post("/HSMS-MS/public/data/delete",{
              delete_table: "HUMANITARNI_BROJ",
              delete_id: id
          },

          function(data) {
            table.api().row('.selected').remove().draw( false );
          });
        }  
      }  
	});

	$('#btn_update').click( function() {
		if(table.api().row('.selected').data() == null) {
			alert("Izaberite red tabele koji zelite izmeniti.");
		} else {
				
				// alert(table.row('.selected').data().organisation);
				var id = table.api().row('.selected').data().id;
				var desc = table.api().row('.selected').data().desc;
				var number = table.api().row('.selected').data().number;
				var price = table.api().row('.selected').data().price;
				var status = table.api().row('.selected').data().status;
				var selectedOrganisation = table.api().row('.selected').data().organisation;
				var web = table.api().row('.selected').data().web;
				var priority = table.api().row('.selected').data().priority;
				var remark = table.api().row('.selected').data().remark;

				$("#desc").val(desc);
	      $("#number").val(number);
	      $("#price").val(price);
	      $("#status").val(status);
	      $("#priority").val(priority);
	      $("#remark").val(remark);

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
	      var btn_submit = document.getElementById('submit');
  			btn_submit.setAttribute('href','javascript:%20check_empty(\'update\', '+id+')');
  			btn_submit.innerHTML = "IZMENI";
		}
	});

  $("#search_key").keyup(function() {
    var key = $("#search_key").val();
    var searchLive = document.getElementById("search_live");
    while (searchLive.firstChild) {
            searchLive.removeChild(searchLive.firstChild);
          }
    if(key.length != 0) {
      $.post("/HSMS-MS/public/data/livesearch", {
      search_key: key
      }, function(res){
        var obj = jQuery.parseJSON(res);
        $("#search_live").show();
        if(obj != null) {
          for(var i=0; i<obj.length; i++) {
            var node = document.createElement("a");
            node.setAttribute("href", obj[i]['web']);
            node.setAttribute("target", "_blank");
            var textNode = document.createTextNode(obj[i]['name']);
            node.appendChild(textNode);
            var breakNode = document.createElement("br");
            searchLive.appendChild(node);
            searchLive.appendChild(breakNode);
          }
        } else {
          var nothingFoundNode = document.createElement("p");
          var textNode = document.createTextNode("Organizacija nije pronađena.");
          nothingFoundNode.appendChild(textNode);
          searchLive.appendChild(nothingFoundNode);
        }
      });
    } else {
      $("#search_live").hide();
    }
  });

});