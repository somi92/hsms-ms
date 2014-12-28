<?php

	class Service extends Controller {

		public function listHSMS($param="") {
			$this->getModel('ModelBroker');
			$data = ModelBroker::loadAllHSMS();
			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($data);
		}

		public function registerDonator() {
			$data = [];
			$res = "";
			$this->getModel('ModelBroker');
			header("Content-Type: application/json; charset=utf-8");
			if(isset($_POST['email'])) {
				$data['email'] = $_POST['email'];
				unset($_POST['email']);
			} else {
				$res['status'] = "Error: please provide a valid email.";
				echo json_encode($res);
				return;
			}
			if(isset($_POST['name'])) {
				$data['name'] = $_POST['name'];
				unset($_POST['name']);
			}
			ModelBroker::registerDonator($data);
			$res['status'] = "Registration successful.";
			
			echo json_encode($res);
		}

		public function donate($params="") {

		}


	}

?>