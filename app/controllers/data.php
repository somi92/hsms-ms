<?php

	class Data extends Controller {

		// ADD SESSION USER CHECK TO ALL METHODS!!!!!!!!
		// if not logged in redirect to home

		public function index($param = "") {
			$this->getView('/data/index', $param);
		}

		public function view($target) {
			$this->getModel('ModelBroker');
			if($target == "hsms") {
				$data = ModelBroker::loadAllHSMS();
				$this->getView('/data/hsms', $data);
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

		public function update($data) {
			// call model and update data
			// call view and update ui
		}

		public function delete($data) {
			// call model and update data
			// call view and update ui
		}
	}

?>