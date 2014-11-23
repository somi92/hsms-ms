<?php 
	
	class Organisation {

		public $id;
		public $name;
		public $desc;
		public $web;

		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getName() {
			return $this->name;
		}

		public function setName($name) {
			$this->name = $name;
		}

		public function getDesc() {
			return $this->desc;
		}

		public function setDesc($desc) {
			$this->desc = $desc;
		}

		public function getWeb() {
			return $this->web;
		}

		public function setWeb($web) {
			$this->web = $web;
		}
	}

?>