<?php

	require_once "MySSP.php";
	require_once "app/config.php";

	$table = 'DONACIJE';
	$primary_key = 'date_time';

	$columns = array(
		array('db' => 'd_email', 'dt' => 0),
		array('db' => 'ime_prezime', 'dt' => 1),
		array('db' => 'opis', 'dt' => 2),
		array('db' => 'cena', 'dt' => 3),
		array('db' => 'date_time', 'dt' => 4)
	);
				
	$joinQuery = " JOIN `DONATORI` AS `DN` ON (`DONACIJE`.`d_email` = `DN`.`email`) JOIN `HUMANITARNI_BROJ` AS `HB` ON (`DONACIJE`.`hb_id` = `HB`.`hb_id`)";

	$sql_details = array(
		'user' => DB_USER,
		'pass' => DB_PASS,
		'db'   => DB_DATABASE,
		'host' => DB_HOST
	);

	$res = MySSP::simple_custom( $_GET, $sql_details, $table, $primary_key, $columns, $joinQuery );
	$res_json = json_encode($res);
	echo $res_json;
	// echo json_encode(
	// 	MySSP::simple_custom( $_GET, $sql_details, $table, $primary_key, $columns, $joinQuery )
	// );
?>