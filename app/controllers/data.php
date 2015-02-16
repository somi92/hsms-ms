<?php

	class Data extends Controller {

		// ADD SESSION USER CHECK TO ALL METHODS!!!!!!!!
		// if not logged in redirect to home

		public function index($param = []) {
			$data = $param ? $param[0] : "";
			$this->getView('/data/index', $data);
		}

		public function view($target) {
			$this->getModel('ModelBroker');
			$view_target = $target ? $target[0] : "";
			if($view_target == "hsms") {
				$data = ModelBroker::loadAllHSMS();
				$this->getView('/data/hsms', $data);
			}
			if($view_target == "donations") {
				$this->getView('/data/donations');
			}
			if($view_target == "organisations") {
				$data = ModelBroker::query("ORGANIZACIJA");
				$this->getView("/data/organisations", $data);
			}
			if($view_target == "stats") {
				$this->getView("/data/stats");
			}
		}

		public function query() {
			
			if(isset($_POST['query_target'])) {
				$this->getModel('ModelBroker');
				$targetTable = $_POST['query_target'];
				echo ModelBroker::query($targetTable);
			}
		}

		public function insert() {
			$data = array();
			if(!isset($_POST['desc']) || !isset($_POST['number']) || !isset($_POST['price'])) {
				// ERROR
				echo "ERROR!";
				return;
			}
			if(isset($_POST['desc'])) {
				$data['desc'] = $_POST['desc']; 
			}
			if(isset($_POST['number'])) {
				$data['number'] = $_POST['number'];
			}
			if(isset($_POST['price'])) {
				$data['price'] = $_POST['price'];
			}
			if(isset($_POST['status'])) {
				$data['status'] = $_POST['status'];
			}
			if(isset($_POST['organisation'])) {
				$data['organisation'] = $_POST['organisation'];
			}
			if(isset($_POST['priority'])) {
				$data['priority'] = $_POST['priority'];
			}
			if(isset($_POST['remark'])) {
				$data['remark'] = $_POST['remark'];
			}

			$this->getModel('ModelBroker');
			echo ModelBroker::insertHSMS("HUMANITARNI_BROJ", $data);
		}

		public function insertorg() {
			$data = array();
			if(!isset($_POST['name']) || !isset($_POST['desc']) || !isset($_POST['web'])) {
				// ERROR
				echo "ERROR!";
				return;
			}
			if(isset($_POST['name'])) {
				$data['name'] = $_POST['name']; 
			}
			if(isset($_POST['desc'])) {
				$data['desc'] = $_POST['desc'];
			}
			if(isset($_POST['web'])) {
				$data['web'] = $_POST['web'];
			}
			$this->getModel('ModelBroker');
			echo ModelBroker::insertOrg("ORGANIZACIJA", $data);
		}

		public function update() {
			// call model and update data
			// call view and update ui
			$data = array();
			if(!isset($_POST['id']) || !isset($_POST['desc']) || !isset($_POST['number']) || !isset($_POST['price'])) {
				// ERROR
				echo "ERROR!";
				return;
			}
			if(isset($_POST['id'])) {
				$data['id'] = $_POST['id']; 
			}
			if(isset($_POST['desc'])) {
				$data['desc'] = $_POST['desc']; 
			}
			if(isset($_POST['number'])) {
				$data['number'] = $_POST['number'];
			}
			if(isset($_POST['price'])) {
				$data['price'] = $_POST['price'];
			}
			if(isset($_POST['status'])) {
				$data['status'] = $_POST['status'];
			}
			if(isset($_POST['organisation'])) {
				$data['organisation'] = $_POST['organisation'];
			}
			if(isset($_POST['priority'])) {
				$data['priority'] = $_POST['priority'];
			}
			if(isset($_POST['remark'])) {
				$data['remark'] = $_POST['remark'];
			}

			$this->getModel('ModelBroker');
			echo ModelBroker::updateHSMS("HUMANITARNI_BROJ", $data);
		}

		public function updateorg() {
			$data = array();
			if(!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['desc']) || !isset($_POST['web'])) {
				// ERROR
				echo "ERROR!";
				return;
			}
			if(isset($_POST['id'])) {
				$data['id'] = $_POST['id']; 
			}
			if(isset($_POST['name'])) {
				$data['name'] = $_POST['name']; 
			}
			if(isset($_POST['desc'])) {
				$data['desc'] = $_POST['desc'];
			}
			if(isset($_POST['web'])) {
				$data['web'] = $_POST['web'];
			}

			$this->getModel('ModelBroker');
			echo ModelBroker::updateOrg("ORGANIZACIJA", $data);
		}

		public function delete($data) {
			// call model and update data
			// call view and update ui
			if(!isset($_POST['delete_id']) || !isset($_POST['delete_table'])) {
				echo "ERROR";
				return;
			} else {
				$table = $_POST['delete_table'];
				$id = $_POST['delete_id'];
				$this->getModel('ModelBroker');
				$ret = ModelBroker::delete($table,$id);
				if($ret == false) {
					echo "false";
				} else {
					echo "true";
				}
			}
		}

		public function livesearch() {
			if(!isset($_POST['search_key'])) {
				echo "ERROR";
				return;
			} else {
				$result = $_POST['search_key'];
				
				$this->getModel('ModelBroker');
				echo ModelBroker::liveSearch($result);
			}
		}

		public function loaddonations($param = "") {
			$this->getModel('ModelBroker');
			// echo var_dump($param);
			echo ModelBroker::loadDonations();
		}
	}

?>