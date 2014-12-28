<?php

	class Donator {

		private $id;
		private $name_surname;
		private $email;
		private $num_of_donations;

		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getNameSurname() {
			return $this->name_surname;
		}

		public function setNameSurname($name_surname) {
			$this->name_surname = $name_surname;
		}

		public function getEmail() {
			return $this->email;
		}

		public function setEmail($email) {
			$this->email;
		}

		public function getNumOfDonations() {
			return $this->num_of_donations;
		}

		public function setNumOfDonations($num_of_donations) {
			$this->num_of_donations = $num_of_donations;
		}
	}

?>