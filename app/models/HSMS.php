<?php

	// require_once "../app/database/DatabaseManager.php";
	// require_once "../app/config.php";

	class HSMS {

		public $id;
		public $desc;
		public $number;
		public $price;
		public $status;
		public $organisation;
		public $web;
		public $priority;
		public $remark;

		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getDesc() {
			return $this->desc;
		}

		public function setDesc($desc) {
			$this->desc = $desc;
		}

		public function getNumber() {
			return $this->number;
		}

		public function setNumber($number) {
			$this->number = $number;
		}

		public function getPrice() {
			return $this->price;
		}

		public function setPrice($price) {
			$this->price = $price;
		}

		public function getStatus() {
			return $this->status;
		}

		public function setStatus($status) {
			$this->status = $status;
		}

		public function getOrganisation() {
			return $this->organisation;
		}

		public function setOrganisation($organisation) {
			$this->organisation = $organisation;
		}

		public function getWeb() {
			return $this->web;
		}

		public function setWeb($web) {
			$this->web = $web;
		}

		public function getPriority() {
			return $this->priority;
		}

		public function setPriority($priority) {
			$this->priority = $priority;
		}

		public function getRemark() {
			return $this->remark;
		}

		public function setRemark($remark) {
			$this->remark = $remark;
		}

		public function loadAllHSMS() {
			$db = new DatabaseManager();
			$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

			$sql = 'select HB.hb_id, HB.opis, HB.broj, HB.cena, ORG.naziv, ORG.website, HB.prioritet, HB.napomena
					from HUMANITARNI_BROJ HB join ORGANIZACIJA ORG on (HB.org_id = ORG.org_id)
					order by HB.prioritet;';
			$result = $db->executeQuery($sql);

			if(!$result->num_rows) {
				return NULL;
			} else {
				while($row = $result->fetch_object()) {
					
					$this->id = $row->hb_id;
					$this->desc = $row->opis;
					$this->price = $row->cena;
					$this->price = $row->cena;
					$this->web = $row->website;
				}
			}
		}
	}

?>