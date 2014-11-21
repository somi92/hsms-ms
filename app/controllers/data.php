<?php

	class Data extends Controller {

		// ADD SESSION USER CHECK TO ALL METHODS!!!!!!!!
		// if not logged in redirect to home

		public function index($param = "") {
			$this->getView('/data/index', $param);
		}

		public function view($target) {
			
		}

		public function query($query) {
			// call model and fetch data
			// call view and update ui
		}

		public function insert($data) {
			// call model and insert data
			// call view and update ui
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