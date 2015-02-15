var table;

function check_empty(action, update_id) {
    var target = "";
    if(action=="insert") {
      target = "/HSMS-MS/public/data/insertorg";
    }
    if(action=="update") {
      target = "/HSMS-MS/public/data/updateorg";
    }
    if (document.getElementById('name').value == "") {
      alert("Morate popuniti naziv!");
    } else {
        var nameF = $("#name").val();
        var descF = $("#desc").val();
        var webF = $("#web").val();

        $.post(target,{
            id: update_id,
            name: nameF,
            desc: descF,
            web: webF
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
}

function div_hide(){

    $("#name").val("");
    $("#desc").val("");
    $("#web").val("");

    document.getElementById('abc').style.display = "none";
}

function loadTable(json_data) {

    table = $('#orgs').dataTable({
      retrieve: true,
      "data": json_data,
      "columns": [
        { "data": "id" },
        { "data": "name" },
        { "data": "desc" },
        { "data": "web" }],

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
      
  $('#orgs tbody').on( 'click', 'tr', function () {
          
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
              delete_table: "ORGANIZACIJA",
              delete_id: id
          },

          function(data) {
            if(data == "true") {
              table.api().row('.selected').remove().draw( false );
            } else {
              alert("Greška! Stavka ne može biti obrisana jer se koristi u drugoj tabeli.");
            }
          });
        }  
      }  
  });

  $('#btn_update').click( function() {
    if(table.api().row('.selected').data() == null) {
      alert("Izaberite red tabele koji zelite izmeniti.");
    } else {
        
        var id = table.api().row('.selected').data().id;
        var name = table.api().row('.selected').data().name;
        var desc = table.api().row('.selected').data().desc;
        var web = table.api().row('.selected').data().web;

        $("#name").val(name);
        $("#desc").val(desc);
        $("#web").val(web);

        document.getElementById('abc').style.display = "block";
          
        var btn_submit = document.getElementById('submit');
        btn_submit.setAttribute('href','javascript:%20check_empty(\'update\', '+id+')');
        btn_submit.innerHTML = "IZMENI";
    }
  });

});