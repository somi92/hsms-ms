<?php

	class DatabaseManager {

		private $connection;

		private $db_host;
		private $db_user;
		private $db_pass;
		private $db_database;

		public function connect($db_host, $db_user, $db_pass, $db_database) {
			
			$this->db_host = $db_host;
			$this->db_user = $db_user;
			$this->db_pass = $db_pass;
			$this->db_database = $db_database;

			$this->connection = new mysqli($db_host, $db_user, $db_pass, $db_database);

			if($this->connection->connect_errno) {
				print_f("Error connecting to database!");
				exit();
			}

			// $this->connection->set_charset("utf8");
			mysqli_set_charset($this->connection, 'utf8');
		}

		public function executeQuery($sql) {	

			if(!$result = $this->connection->query($sql)) {
				print_f("Error executing query from database!");
				exit();
			}

			$this->connection->close();
			return $result;
		}


	}

?>