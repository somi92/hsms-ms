<?php 

	require_once "../app/config.php";
	require_once "../app/database/DatabaseManager.php";

	// class used to delegate call to Database Manager

	/*
		https://developer.yahoo.com/yql/console/?q=show%20tables&env=store://datatables.org/alltableswithkeys#h=select+*+from+yahoo.finance.xchange+where+pair+in+(%22EURRSD%22)
		https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22EURRSD%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=
		https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDRSD%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=
	*/
	class ModelBroker {

		private static $rsd_to_eur = 0;
		private static $rsd_to_usd = 0;

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

		public static function loadAllHSMS($convert = "") {

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

					if($convert == "eur" || $convert == "usd") {
						$a = explode(" ", $row->cena);
						$amount = intval($a[0]);
						$hsms->setPrice(self::convertRSD($amount, $convert));
					} else {
						$hsms->setPrice($row->cena);
					}

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

		public static function updateHSMS($targetTable, $data) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			
			$sql = "update ".$targetTable." set 
					opis = '".$data['desc']."', broj = '".$data['number']."',
					cena = '".$data['price']."', hb_status = '".$data['status']."',
					prioritet = ".$data['priority'].", napomena = '".$data['remark']."',
					org_id = ".$data['organisation']."
					where hb_id = ".$data['id'].";";
			$db->executeQuery($sql);

			$result = self::loadAllHSMS();
			return json_encode($result["actions"]);

		}

		public static function liveSearch($key) {
			
			require_once "../app/models/Organisation.php";

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = "select org_id, naziv, opis, website from ORGANIZACIJA where
					naziv like '%".$key."%' order by naziv;";
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

		public static function registerDonator($data) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			$num = 0;
			$name = "";
			if(isset($data['name'])) {
				$name = $data['name'];
			}
			$sql = "insert into DONATORI values('', '".$name."', '".$data['email']."', ".$num.");";
			$result = $db->executeQuery($sql);

			return $result;
		}

		public static function updateDonator($email_target, $name) {
			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = "update DONATORI set ime_prezime = '".$name."' where email = '".$email_target."';";
			$result = $db->executeQuery($sql);

			return $result;
		}

		public function donate($email, $id) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = "insert into DONACIJE (d_email, hb_id) values ('".$email."',".$id.");";
			$result = $db->executeQuery($sql);

			return $result;
		}

		public function convertRSD($rsd, $target) {

			if($target == "eur") {
				if(self::$rsd_to_eur == 0) {
					$url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22EURRSD%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
					$curl = curl_init($url);
					// curl_setopt($curl, CURLOPT_PROXY, 'proxy.fon.rs:8080');
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_POST, false);

					$response = curl_exec($curl);
					curl_close($curl);

					$result = json_decode($response);
					self::$rsd_to_eur = intval($result->query->results->rate->Rate);
				}

				return round($rsd/self::$rsd_to_eur, 2)." eur";
			}

			if($target == "usd") {
				if(self::$rsd_to_usd == 0) {
					$url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDRSD%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
					$curl = curl_init($url);
					// curl_setopt($curl, CURLOPT_PROXY, 'proxy.fon.rs:8080');
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_POST, false);

					$response = curl_exec($curl);
					curl_close($curl);

					$result = json_decode($response);
					self::$rsd_to_usd = intval($result->query->results->rate->Rate);
				}

				return round($rsd/self::$rsd_to_usd, 2)." usd";
			}
		}

		public function donationStats($param) {

			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$target[0] = "";
			$target[1] = "";
			if($param == "donators") {
				$target[0] = "d_email";
				$target[1] = "dn.ime_prezime";
			}
			if($param == "hsms") {
				$target[0] = "hb_id";
				$target[1] = "hb.opis";
			}

			$sql = "SELECT dnc.".$target[0]." AS id, ".$target[1]." AS descr, count(dnc.".$target[0].") AS counter FROM 
					DONACIJE dnc JOIN HUMANITARNI_BROJ hb ON (dnc.hb_id = hb.hb_id) JOIN 
					DONATORI dn ON (dn.email = dnc.d_email) GROUP BY dnc.".$target[0].";";
			$result = $db->executeQuery($sql);
			$data = [];
			if(!$result->num_rows) {
				$data = NULL;
			} else {
				while($row = $result->fetch_object()) {
					
					$item = [];

					$item["id"] = $row->id;
					$item["desc"] = $row->descr;
					$item["count"] = $row->counter;

					$data["stats"][] = $item;
				}
			}

			return $data;
		}

		public function loadDonations() {
			require_once "MySSP.php";

			$table = 'DONACIJE';
			$primary_key = 'date_time';

			$columns = array(
				array('db' => 'd_email', 'dt' => 0),
				array('db' => 'ime_prezime', 'dt' => 1),
				array('db' => 'opis', 'dt' => 2),
				array('db' => 'cena', 'dt' => 3),
				array('db' => 'date_time', 'dt' => 4)
			);
						
			$joinQuery = " JOIN `DONATORI` AS `DN` ON (`DONACIJE`.`d_email` = `DN`.`email`) JOIN `HUMANITARNI_BROJ` AS `HB` ON (`DONACIJE`.`hb_id` = `HB`.`hb_id`)";

			$sql_details = array(
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db'   => DB_DATABASE,
				'host' => DB_HOST
			);

			echo json_encode(
				MySSP::my_simple( $_GET, $sql_details, $table, $primary_key, $columns, $joinQuery )
			);
		}

	}

?>