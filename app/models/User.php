<?php

	// require_once "../app/database/DatabaseManager.php";
	// require_once "../app/config.php";

	class User {

		private $id;
		private $role;
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

		public function getRole() {
			return $this->role;
		}

		public function setRole($role) {
			$this->role = $role;
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
	}

?>