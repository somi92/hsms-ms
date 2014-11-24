<?php 

	require_once "../app/config.php";
	require_once "../app/database/DatabaseManager.php";

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
				$user->setName(NULL);
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

			$data = array();
			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = 'SELECT HB.hb_id, HB.opis, HB.broj, HB.cena, HB.hb_status, ORG.naziv, ORG.website, HB.prioritet, HB.napomena
					FROM HUMANITARNI_BROJ HB JOIN ORGANIZACIJA ORG ON (HB.org_id = ORG.org_id)
					ORDER BY HB.prioritet;';
			$result = $db->executeQuery($sql);

			if(!$result->num_rows) {
				$data = NULL;
			} else {
				while($row = $result->fetch_object()) {
					
					$hsms = new HSMS();
					
					$hsms->setId($row->hb_id);
					$hsms->setDesc($row->opis);
					$hsms->setNumber($row->broj);
					$hsms->setPrice($row->cena);
					$hsms->setStatus($row->hb_status);
					$hsms->setOrganisation($row->naziv);
					$hsms->setWeb($row->website);
					$hsms->setPriority($row->prioritet);
					$hsms->setRemark($row->napomena);

					$data["actions"][] = $hsms;

				}

				return $data;
				// start session
				// session_start();
				// $_SESSION['data'] = $data;
			}

		}

		public static function insertHSMS($targetTable, $data) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = "insert into ". 
				$targetTable." values ".
				"('','".$data['desc']."','".$data['number']."','".$data['price']."','".
					$data['status']."',".$data['priority'].",'".$data['remark']."',".$data['organisation'].")";
			$db->executeQuery($sql);

			$result = self::loadAllHSMS();
			return json_encode($result["actions"]);
		}

		public static function query($targetTable) {
			
			require_once "../app/models/Organisation.php";

			$data = array();
			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = "select * from ".$targetTable." order by org_id;";

			$result = $db->executeQuery($sql);
			if(!$result->num_rows) {
				$data = NULL;
			} else {
				while($row = $result->fetch_object()) {
					
					$org = new Organisation();
					
					$org->setId($row->org_id);
					$org->setName($row->naziv);
					$org->setDesc($row->opis);
					$org->setWeb($row->website);

					$data["organisations"][] = $org;

				}

			}
			return json_encode($data["organisations"]);
		}

		public static function delete($targetTable, $rowId) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = "delete from ".$targetTable." where hb_id = ".$rowId.";";

			if($db->executeQuery($sql) == false) {
				return false;
			}
			return true;
		}


	}

?>