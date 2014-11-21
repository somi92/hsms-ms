<?php 

	require_once "../app/config.php";

	// class used to delegate call to Database Manager
	class ModelBroker {

		public static function loadUser($id) {

			require_once "../app/models/User.php";

			$user = new User();
			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = 'SELECT id, ime, prezime, website FROM USERS WHERE id="'.$id.'";';
			$result = $db->executeQuery($sql);

			if(!$result->num_rows) {
				$user->name = NULL;
			} else {
				while($row = $result->fetch_object()) {
					
					$user->setID($row->id);
					$user->setName($row->ime);
					$user->setSurname($row->prezime);
					$user->setWebsite($row->website);
				}
				// start session
				session_start();
				$_SESSION['auth_user'] = $user;
			}
		}

		public static function loadAllHSMS() {

			require_once "../app/models/HSMS.php";

			$hsms = new HSMS();
			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = 'SELECT id, ime, prezime, website FROM USERS WHERE id="'.$id.'";';
			$result = $db->executeQuery($sql);
		}

	}

?>