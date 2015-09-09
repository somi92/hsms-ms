<?php

	class Service extends Controller {

		public function listhsms($param="") {
			$this->getModel('ModelBroker');
			$data = "";
			if(isset($param[0]) && ($param[0]=="eur:true" || $param[0]=="usd:true")) {
				if($param[0]=="eur:true") {
					$data = ModelBroker::loadAllHSMS("eur");
				}
				if($param[0]=="usd:true") {
					$data = ModelBroker::loadAllHSMS("usd");
				}
			} else {
				$data = ModelBroker::loadAllHSMS();
			}
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
			$result = ModelBroker::registerDonator($data);
			$res['status'] = "Registration successful.";

			if($result != 1) {
				$res['status'] = "Error: email already registered.";
			}
			echo json_encode($res);
		}

		public function donate($params="") {
			$this->getModel('ModelBroker');
			$res = [];
			$param1 = [];
			$param2 = [];
			header("Content-Type: application/json; charset=utf-8");
			if(count($params)==2) {
				$param1 = explode(":",$params[0]);
				if($param1[0] != "email") {
					$res['status'] = "Error: parameter 'email' not found.";
					echo json_encode($res);
					return;
				}
				$param2 = explode(":",$params[1]);
				if($param2[0] != "id") {
					$res['status'] = "Error: parameter 'id' not found.";
					echo json_encode($res);
					return;
				}

				$result = ModelBroker::donate($param1[1], intval($param2[1]));
				$res['status'] = "Donation registered successfuly.";
				if($result != 1) {
					$res['status'] = "Error: could not finish transaction, check your api call and try again.";
				}
				echo json_encode($res);

			} else {
				$res['status'] = "Error: invalid parameter list.";
				echo json_encode($res);
				return;
			}
		}

		public function updatedonator() {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->getModel('ModelBroker');
				$put_vars = [];
				parse_str(file_get_contents("php://input"),$put_vars);

				if(!isset($put_vars['email']) || !isset($put_vars['name'])) {
					$res['status'] = "Error: invalid parameters.";
					echo json_encode($res);
					return;
				}

				$email_target = $put_vars['email'];
				$name = $put_vars['name'];
				
				$result = ModelBroker::updateDonator($email_target, $name);
				if($result != 1) {
					$res['status'] = "Error: could not finish transaction.";
				} else {
					$res['status'] = "Donator updated successfuly.";
				}
				echo json_encode($res);
			}
		}

		public function test($params = []) {
			if($_SERVER['REQUEST_METHOD'] == 'GET') {
				$res['status'] = "GET ".$params[0];
				echo json_encode($res);
			}
			if($_SERVER['REQUEST_METHOD'] == 'PUT') {
				$post_vars = [];
				parse_str(file_get_contents("php://input"),$post_vars);
				$res['status'] = "PUT ".$params[0];
				echo json_encode($res);
			}
			if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
				$post_vars = [];
				parse_str(file_get_contents("php://input"),$post_vars);
				$res['status'] = "DELETE ".$post_vars['a'];
				echo json_encode($res);
			}
		}

		public function testC($param) {
			$this->getModel('ModelBroker');
			$result = ModelBroker::convertRSDtoEUR(intval($param[0]));
			$res['status'] = $result;
			echo json_encode($res);
		}

		public function donationstats($param = "") {
			$target = explode(":",$param[0]);
			if($target[0] != "target" || ($target[1] != "donators" && $target[1] != "hsms")) {
				$res['status'] = "Error: invalid parameter.";
				echo json_encode($res);
				return;
			}
			$this->getModel('ModelBroker');
			$result = ModelBroker::donationStats($target[1]);
			// if($result != 1) {
			// 	$res['status'] = "Error: invalid parameter.";
			// } else {
			// 	$res = $result;
			// }
			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($result);
			// echo $result;
		}

		public function organisations() {
			$this->getModel('ModelBroker');
			$result = ModelBroker::getOrgs();
			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($result);
		}

	}

?>