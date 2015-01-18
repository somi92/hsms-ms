<?php
	
	require( '../public/res/DataTables-1.10.4/examples/server_side/scripts/ssp.class.php' );

	class MySSP extends SSP {

		static function my_simple( $request, $sql_details, $table, $primaryKey, $columns, $joinQuery) {
			$bindings = array();
			$db = self::sql_connect( $sql_details );

			// Build the SQL query string from the request
			$limit = self::limit( $request, $columns );
			$order = self::order( $request, $columns );
			$where = self::filter( $request, $columns, $bindings );

			// Main query to actually get the data
			$data = self::sql_exec( $db, $bindings,
			"SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $joinQuery
			 $where
			 $order
			 $limit"
			);

			// Data set length after filtering
			$resFilterLength = self::sql_exec( $db,
			"SELECT FOUND_ROWS()"
			);
			$recordsFiltered = $resFilterLength[0][0];

			// Total data set length
			$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`"
			);
			$recordsTotal = $resTotalLength[0][0];

			/*
			 * Output
			 */
			// echo var_dump($data);
			$result = array(
				"draw"            => intval( $request['draw'] ),
				"recordsTotal"    => intval( $recordsTotal ),
				"recordsFiltered" => intval( $recordsFiltered ),
				"data"            => self::data_output( $columns, $data )
			);
			// echo var_dump($result);
			return $result;
			// return array(
			// "draw"            => intval( $request['draw'] ),
			// "recordsTotal"    => intval( $recordsTotal ),
			// "recordsFiltered" => intval( $recordsFiltered ),
			// "data"            => self::data_output( $columns, $data )
			// );
		}
	}

?>