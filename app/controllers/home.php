<?php

	require_once "../app/database/DatabaseManager.php";

	class Home extends Controller {

		public function index($param = []) {

			$user = NULL;
			$data = $param ? $param[0] : "";
			$this->getView('home/index', $data);
		}

		public function login($param = []) {
			
			if(isset($_SESSION)) {
				session_start();
			} else {
				if(isset($_POST['userid']) && isset($_POST['password'])) {
				$userid = $_POST['userid'];
				$password = $_POST['password'];
				// $user = $this->getModel('ModelBroker');
				// $user->loadUser($userid);
				$this->getModel('ModelBroker');
				ModelBroker::loadUser($userid, $password);
				unset($_POST);
				$param[0] = "logging";
				if(!isset($_SESSION['auth_user'])) {
					header("Location: /HSMS-MS/public/home/index/".$param[0]);
      			} else {
      				header("Location: /HSMS-MS/public/home/index");
      			}
			} else {

				}				
			}

		}

		public function logout() {
			if(!isset($_SESSION)) { 
        		session_start();
        		$_SESSION = array();
				session_destroy();
				$param[0] = "logout";
				$this->getView('home/index', $param[0]);
    		} 
		}
	}

?>