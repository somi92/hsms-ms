<?php 

	class PageTemplate {

		public function showHeader() {
			echo "<h1>HSMS Management System</h1>";
		}

		public function showFooter() {

		}

		public function showWelcome() {
			
		}

		public function showManagementPanel() {
			echo '</br></br>';
			echo '<a href="/HSMS-MS/public/data/index">Data management</a>';
			echo '</br></br>';
		}

		public function showLoginForm() {
			echo '<form action="/HSMS-MS/public/home/login" method="post">
						Unesite vas ID:<br>
						<input type="text" name="userid" value="">
						<br>
						<input type="submit" value="Submit">
				   </form>';
		}

		public function showTable($data) {

		}

		public function loadHSMSAddForm() {

		}
	}

?>