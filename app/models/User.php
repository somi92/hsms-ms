<?php

	// require_once "../app/database/DatabaseManager.php";
	// require_once "../app/config.php";

	class User {

		private $id;
		private $name;
		private $surname;
		private $web;

		/* getters and setters */
		public function getID() {
			return $this->id;
		}

		public function setID($id) {
			$this->id = $id;
		}

		public function getName() {
			return $this->name;
		}

		public function setName($name) {
			$this->name = $name;
		}

		public function getSurname() {
			return $this->surname;
		}

		public function setSurname($surname) {
			$this->surname = $surname;
		}

		public function getWebsite() {
			return $this->web;
		}

		public function setWebsite($website) {
			$this->website = $website;
		}

		/*
		public function loadUser($id) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = 'SELECT id, ime, prezime, website FROM USERS WHERE id="'.$id.'";';
			$result = $db->executeQuery($sql);

			if(!$result->num_rows) {
				$this->name = NULL;
			} else {
				while($row = $result->fetch_object()) {
					
					$this->id = $row->id;
					$this->name = $row->ime;
					$this->surname = $row->prezime;
					$this->web = $row->website;
				}
				// start session
				session_start();
				$_SESSION['auth_user'] = $this;
			}
		}*/
	}

?>