$(document).ready(function(){

$("#donations").dataTable({ 

 	"columns": [
            { "title": "Email" },
            { "title": "Ime i prezime" },
            { "title": "Opis" },
            { "title": "Cena" },
            { "title": "Datum i vreme" } 
        ],
    "ajax": "/HSMS-MS/public/data/loaddonations",  
 	"processing": true,
	"serverSide": true,
	"language": {
		"url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Serbian.json"
	}
});

});